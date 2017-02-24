<?php



class HongKongPost extends Shipping_Abstract
{
    /*------------------------------------------------------ */
    //-- PUBLIC ATTRIBUTEs
    /*------------------------------------------------------ */

    /**
     * 配置信息
     */
    var $_configure_des= array(
      'calculateway' => '免费',
      'default' => 'weight',
      'btn' => '保存',
    );

    var $_configure;
    /*------------------------------------------------------ */
    //-- PUBLIC METHODs
    /*------------------------------------------------------ */

    /**
     * 构造函数
     * @return null
     */
    public function initialize($configure = null)
    {
      if ($configure) {
        $this->_configure = $configure;
      }
    }

    /**
     * 计算订单的配送费用的函数
     *
     * @param   float   $goods_weight   商品重量
     * @param   float   $goods_amount   商品金额
     * @param   float   $goods_number   商品件数
     * @return  decimal
     */
    public function calculate($goods_weight, $goods_amount, $goods_number)
    {
      return 0;
    }
}
