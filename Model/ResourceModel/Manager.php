<?php
namespace Magenman\CallToOrder\Model\ResourceModel;

/**
 * Class Manager
 * @package Magenman\CallToOrder\Model\ResourceModel
 */
class Manager extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    public function _construct()
    {
        $this->_init('magenman_call_to_order_manager', 'id');
    }
}
