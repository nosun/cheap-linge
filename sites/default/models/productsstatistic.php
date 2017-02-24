<?php
class ProductsStatistic_Model extends Bl_Model
{
	const TYPE_SHARE = 1;
	const TYPE_BOUGHT = 2;
	
	/**
	 * @return ProductsStatistic_Model
	 */
	public static function getInstance()
	{
		return parent::getInstance(__CLASS__);
	}
	
	
	public function insertItem($pid, $type)
	{
		global $db;
		
		$db->insert('products_statistic', array('pid' => $pid, 'type' => $type));
		return intval($db->actived()) > 0;
	}
	
	public function updateItem($pid, $type)
	{
		global $db;
		if ($this->getItem($pid, $type)) {
			$sql = sprintf('update products_statistic set count = count + 1 where pid = "%s" and type = %d',$pid, $type);
			$db->exec($sql);
			return intval($db->actived()) > 0;
		} else {
			return $this->insertItem($pid, $type);
		}
	}
	
	public function getItem($pid, $type = null)
	{
		global $db;
		
		$db->where('pid', $pid);
		if (isset($type))
		{
			$db->where('type', $type);
		}
		$result = $db->get('products_statistic');
		
		return $result->allWithKey('type');
	}
}