<?php
class Comment_Controller extends Bl_Controller
{
  private $_commentModel;
  
  public function init()
  {
    $this->_commentModel = Comment_Model::getInstance();
  }
  
  public function insertAction()
  {
    global $user;
    if ($this->isPost()) {
      $post = $_POST;
      if (!$post['nickname']){
        exit('Name can not be empty!');
      }

      if ($post['comment']) {
        exit('Review content can not be empty');
      }
      $post['comment'] = trim($post['comment']);
      $post['comment'] = strip_tags($post['comment']);
      if (!$post['subject']) {
        $post['subject'] = substr($post['comment'], 0, 50);
        $pos = strpos($post['subject'], "\n");
        if($pos !== false){
        	$post['subject'] = strpos($post['subject'], $needle);
        }
      }
      $post['comment'] = preg_replace("/\r\n(\r\n)+/", "</p><p>", $post['comment']);
      $post['comment'] = preg_replace("/\n(\n)+/", "</p><p>", $post['comment']);
      
      $post['comment'] = str_ireplace("\r\n", "</br>", $post['comment']);
      $post['comment'] = str_ireplace("\n", "</br>", $post['comment']);
      
      $uid = isset($user->uid) ? $user->uid : 0;
      $nickname = (isset($_POST['nickname']) && $_POST['nickname']) ? $_POST['nickname'] : (isset($user->nickname) ? $user->nickname : $user->name);
      $productInstance = Product_Model::getInstance();
      if ($productInstance->getProductInfo($post['pid'])) {
        $status = Bl_Config::get('isNeedAudit', 1) == 1 ? 0 : 1;
        $cid = $this->_commentModel->insertComment($uid, $post['subject'], $post['comment'], $nickname, $status);
        if ($cid) {
          cache::remove('product-' . $post['pid']);
          $this->_commentModel->insertProductComments($post['pid'],$cid);
          if (isset($post['rating'])) {
            $grade = $post['rating'];
            widgetCallFunction('fivestars', 'setstars', $post['pid'], $cid, $grade);
            cache::remove('productStart-' . $post['pid']);
          }
        }
        $reffer_url = $_SERVER["HTTP_REFERER"];
        if(isset($post['referer']) && $post['referer']) {
          gotoUrl($post['referer']); 
        } elseif (isset($reffer_url) && $reffer_url) {
          header("Location: ".$reffer_url); 
        } else {
          gotoUrl('comment/insert');
        }
      } else {
        //TODO
        exit('No goods');
      }
    } else {
      $this->view->render('user/addComment.phtml', array());
    }
  }


  public function ajaxUpdateUserAttitudeAction(){
    
  }


  public function addReplyAction()
  {
    global $user;
    if ($this->isPost()) {
      $post = $_POST;
      if (!$post['uid']){
        exit('You need to first login to add reply!');
      }
      if (!$post['review_comment']) {
        exit('Review comment should not be empty!');
      }
      if(strpos($post['review_comment'], '<a ') !== false || strpos($post['review_comment'], 'href') !== false){
        $arr = array();
        $arr['ok'] = false;
      }else{
        $uid = isset($user->uid) ? $user->uid : 0;
        $nickname = (isset($user->nickname) && $user->nickname != '') ? $user->nickname : $user->name;
        $email = $user->email;
  
        $status = Bl_Config::get('isNeedAudit', 1) == 1 ? 0 : 1;
        
        $cid = $this->_commentModel->insertComment($uid, $email, $post['review_comment'], $nickname, $status, '', $post['replyid']);
        
        $arr = $this->_commentModel->getReplyCommentInfo($cid);
        $arr->time = date('M d, Y', $arr->timestamp);
        $arr->ok = true;
      }
      echo json_encode($arr);
    }
  }
  
  
}