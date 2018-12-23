<?php
namespace Magenman\CallToOrder\Block\Adminhtml;

/**
 * Class Manager
 * @package Magenman\CallToOrder\Block\Adminhtml
 */
class Manager extends \Magento\Backend\Block\Widget\Grid\Container
{
    protected function _construct()
    {
        $this->_blockGroup  = 'Magenman_CallToOrder';
        $this->_controller  = 'adminhtml_manager';
        parent::_construct();
        $this->removeButton('add');
    }
}
