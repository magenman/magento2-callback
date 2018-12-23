<?php

namespace Magenman\CallToOrder\Block\Product\View;

use Magento\Catalog\Block\Product\AbstractProduct;

/**
 * Class Extra
 * @package Magenman\CallToOrder\Block\Product\View
 */
class Extra extends AbstractProduct
{
    /**
     * @return array
     */
    public function getConfig()
    {
        $model = \Magento\Framework\App\ObjectManager::getInstance()->create('Magento\Framework\App\Config\ScopeConfigInterface');
        $phone =  $model->getValue('calltoorder_setting/call_order/phone', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $enable = $model->getValue('calltoorder_setting/call_order/enabled', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $preferTime = $model->getValue('calltoorder_setting/call_order/time_to_call', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        return [
            'phone' => $phone,
            'enable' => $enable,
            'prefer_time' => $preferTime,
        ];
    }

    /**
     * @return string
     */
    public function getAjax()
    {
        return $this->getUrl('calltoorder/product/save');
    }
}
