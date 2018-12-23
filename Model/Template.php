<?php
namespace Magenman\CallToOrder\Model;

/**
 * Class Template
 * @package Magenman\CallToOrder\Model
 */
class Template extends \Magento\Framework\Model\AbstractModel
{
    public function _construct()
    {
        $this->_init('Magenman\CallToOrder\Model\ResourceModel\Template');
    }
}
