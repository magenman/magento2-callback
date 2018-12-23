<?php
namespace Magenman\CallToOrder\Model\ResourceModel;

/**
 * Class Template
 * @package Magenman\CallToOrder\Model\ResourceModel
 */
class Template extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    public function _construct()
    {
        $this->_init('magenman_call_to_order_template', 'id');
    }
}
