<?php
namespace Magenman\CallToOrder\Model;

/**
 * Class Manager
 * @package Magenman\CallToOrder\Model
 */
class Manager extends \Magento\Framework\Model\AbstractModel
{
    public function _construct()
    {
        $this->_init('Magenman\CallToOrder\Model\ResourceModel\Manager');
    }
}
