<?php
require_once("api_common.php");

class Api_Product_Controller extends Api_Model
{
	private $_productInstance;
	private $_userInstance;

	public static function __funcs()
	{
		return array(
		'getlist',
		'getinfo',
		'downloadVocabulary',
		'downloadSpecial',
		'downloadProduct',
		'downloadType',
		'downloadField',
		'uploadVocabulary',
		'uploadSpecial',
		'uploadProduct',
		'uploadType',
		'uploadField',
		'uploadImages',
		);
	}

	public function init()
	{
		$this->_userInstance = User_Model::getInstance();
		$this->_productInstance = Product_Model::getInstance();
		$this->_taxonomy = Taxonomy_Model::getInstance();
	}
	
	
	public function getlist()
	{
		if (!$this->_userInstance->logged()) {
			return PHPRPC_Authentication(0, "no login");
		}
		//return PHPRPC_Authentication(0, "no login");
	}

	public function getinfo()
	{
		return "";
	}


	



	//客户端从服务器更新分类信息到本地
	public function downloadVocabulary()
	{
		if (!$this->_userInstance->logged()) {
			return PHPRPC_Authentication(0, "no login");
		}

		$list = $this->_taxonomy->getVocabularyList();
		
		$list = json_encode($list);
		return $list;
	}

	//客户端从服务器更新特殊分类信息到本地
	public function downloadSpecial()
	{

	}

	// 客户端从服务器更新产品信息到本地
	public function downloadProduct()
	{

	}

	//客户端从服务器更新单值属性信息到本地
	public function downloadType()
	{

	}

	//客户端从服务器更新多值属性信息到本地
	public function downloadField()
	{

	}

	// 将客户端录入的分类数据上传到服务器端
	public function uploadVocabulary()
	{

	}

	//将客户端录入的特殊分类数据上传到服务器端
	public function uploadSpecial()
	{

	}

	//将客户端录入的产品数据上传到服务器端
	public function uploadProduct()
	{

	}

	// 将客户端录入的单值属性数据上传到服务器端
	public function uploadType()
	{

	}

	//将客户端录入的多值属性数据上传到服务器端
	public function uploadField()
	{

	}

	//将客户端的图片上传到服务器端。要提供一个是否作为默认图片的标记。提供图片后缀名属性
	public function uploadImages()
	{

	}





}

