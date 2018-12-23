<?php

namespace Magenman\CallToOrder\Model\ResourceModel\Template;

/**
 * Class Collection
 * @package Magenman\CallToOrder\Model\ResourceModel\Template
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    public function _construct()
    {
        $this->_init('Magenman\CallToOrder\Model\Template', 'Magenman\CallToOrder\Model\ResourceModel\Template');
    }
}
