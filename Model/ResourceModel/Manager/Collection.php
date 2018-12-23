<?php

namespace Magenman\CallToOrder\Model\ResourceModel\Manager;

/**
 * Class Collection
 * @package Magenman\CallToOrder\Model\ResourceModel\Manager
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    public function _construct()
    {
        $this->_init('Magenman\CallToOrder\Model\Manager', 'Magenman\CallToOrder\Model\ResourceModel\Manager');
    }
}
