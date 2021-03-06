<?php
class Admin_SizeChart_Controller extends Bl_Controller
{
	public static function __permissions()
	{
		return array(
			'manage sizechart',
		);
	}
	
	public function checkSizeChart($sizeChart)
	{
	    if (!isset($sizeChart))
	    {
	        setMessage('服务器接收数据错误', 'error');
	        return false;
	    }
	    if (!isset($sizeChart['name']) || strlen(trim($sizeChart['name'])) <= 0)
	    {
	        setMessage('Size Chart的名字不能为空', 'error');
	        return false;
	    }
	    if (!isset($sizeChart['brand_tid']) && $sizeChart['brand_tid'] <= 0)
	    {
	        setMessage('Size Chart的品牌不能为空', 'error');
	        return false;
	    }
	    if (!isset($sizeChart['content']) || strlen(trim($sizeChart['content'])) <= 0)
	    {
	        setMessage('Size Chart的内容不能为空', 'error');
	        return false;
	    }
	    return true;
	}
	
	public function listAction()
	{
		if (!access('manage sizechart'))
		{
			goto403('Access Denied.');	
		}
		$sizeChartList = SizeChart_Model::getInstance()->getSizeChartList();
		$this->view->render('admin/sizechart/list.phtml', array(
		                    'sizeChartList' => $sizeChartList));
	}
	
	public function addAction()
	{
		if (!access('manage sizechart'))
		{
			goto403('Access Denied.');
		}
		
		if ($this->isPost())
		{
		    $sizeChart = $_POST;
		    if ($this->checkSizeChart($sizeChart))
		    {
		        if (SizeChart_Model::getInstance()->insertSizeChart($sizeChart))
		        {
		            setMessage("新建Size Chart:" . $sizeChart['name'] . '成功', 'notice');
		            gotoUrl("admin/sizechart/list");
		        } 
    		    else 
    		    {
    		        setMessage("新建Size Chart失败", 'error');
    		    }
		    }
		}
		$this->view->addJs(url('scripts/xheditor/xheditor-zh-cn.min.js'));
        $this->view->addJs(url('scripts/swfupload-jquery/vendor/swfupload/swfupload.js'));
        $this->view->addJs(url('scripts/swfupload-jquery/src/jquery.swfupload.js'));
        $this->view->addCss(url('scripts/swfupload-jquery/css/default.css'));
        $brandList = Taxonomy_Model::getInstance()->getTermsListByType(Taxonomy_Model::TYPE_BRAND);
		$this->view->render('admin/sizechart/add.phtml', array(
		                    'brandList' => $brandList));
	}

    public function updateAction($id = 0)
    {
        if (!access('manage sizechart'))
		{
			goto403('Access Denied.');
		}
		
		$sizeChart = SizeChart_Model::getInstance()->getSizeChartById($id);
		if (isset($sizeChart))
		{
		    if ($this->isPost())
		    {
		        $updateSizeChart = $_POST;
		        if (isset ($updateSizeChart) && isset($updateSizeChart['id']))
		        {
		            // 判断页面的url中包含的id和真实的id不一致的情况
		            if ($id != $updateSizeChart['id'])
		            {
		                setMessage('页面数据错误', 'error');
		            }
		            else if ($sizeChart->name == $updateSizeChart['name'] && 
		                $sizeChart->brand_tid == $updateSizeChart['brand_tid'] &&
		                $sizeChart->content == $updateSizeChart['content'])
		            {
		                setMessage('页面数据未改动', 'error');
		            }
		            else 
		            {
		                if ($this->checkSizeChart($updateSizeChart))
		                {
		                    if (SizeChart_Model::getInstance()->updateSizeChart($updateSizeChart))
		                    {
		                        setMessage("更新Size Chart:" . $updateSizeChart['name'] . '成功', 'notice');
		                        gotoUrl('admin/sizechart/list');
		                    }
		                    else 
		                    {
		                        setMessage('更新Size chart失败', 'error');
		                    }
		                }
		            }
		        }
		        else 
		        {
		            setMessage('输入数据错误', 'error');
		        }
		    }
		    $this->view->addJs(url('scripts/xheditor/xheditor-zh-cn.min.js'));
            $this->view->addJs(url('scripts/swfupload-jquery/vendor/swfupload/swfupload.js'));
            $this->view->addJs(url('scripts/swfupload-jquery/src/jquery.swfupload.js'));
            $this->view->addCss(url('scripts/swfupload-jquery/css/default.css'));
            $brandList = Taxonomy_Model::getInstance()->getTermsListByType(Taxonomy_Model::TYPE_BRAND);
		    $this->view->render('admin/sizechart/update.phtml', array(
		                    	'brandList' => $brandList,
		                        'sizeChart' => $sizeChart));
		}
		else 
		{
		    gotoUrl('admin/sizechart/list');
		}
    }

    public function deleteAction($id = 0)
    {
        if (!access('manage sizechart'))
		{
			goto403('Access Denied.');
		}
		$sizeChart = SizeChart_Model::getInstance()->getSizeChartById($id);
		if (!isset($sizeChart))
		{
		    setMessage('没找到指定的Size Chart', 'error');
		}
		else
		{
		    if (SizeChart_Model::getInstance()->deleteSizeChart($id))
		    {
		        setMessage('删除Size Chart:' . $sizeChart->name . ' 成功', 'notice');
		    }
		    else 
		    {
		        setMessage('删除Size Chart:' . $sizeChart->name . ' 失败', 'error');
		    }
		}
		gotoUrl('admin/sizechart/list');
    }
}