<?php

namespace Magenman\CallToOrder\Block\Adminhtml\Report;

/**
 * Class Report
 * @package Magenman\CallToOrder\Block\Adminhtml\Report
 */
class Report extends \Magento\Backend\Block\Template
{
    /**
     * @var \Magenman\CallToOrder\Model\ManagerFactory
     */
    protected $manager;

    /**
     * Report constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magenman\CallToOrder\Model\ManagerFactory $managerFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magenman\CallToOrder\Model\ManagerFactory $managerFactory,
        \Magento\Backend\Model\UrlInterface $backendUrl,
        array $data
    ) {
        parent::__construct($context, $data);
        $this->manager = $managerFactory;
        $this->_backendUrl = $backendUrl;
    }

    /**
     * @return mixed
     */
    public function getConfig()
    {
        $model = \Magento\Framework\App\ObjectManager::getInstance()->
        create('Magento\Framework\App\Config\ScopeConfigInterface');
        $pattern =  $model->getValue(
            'calltoorder_setting/call_order/phone',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );

        return $pattern;
    }

    /**
     * @return array
     */
    public function getProduct()
    {
        $data = $this->manager->create()->getCollection();
        $array = [];
        foreach ($data as $info) {
            $id = $info->getProductId();
            
            array_push($array, $id);
        }

        $result = array_count_values($array);
        $arrayTest = [];
        $i = 0;
        foreach ($result as $key => $value) {
            $info =   $this->manager->create()->getCollection()
                ->addFieldToFilter('product_id', $key)->getFirstItem();
            $arrayNew[$i] = [
                'name' => $info->getProductName(),
                'qty' => $value,
                'url' => $this->getUrl('catalog/product/edit', ['id'=>$key])
            ];
            $arrayTest = array_merge($arrayNew, $arrayTest);
        }
        
        return $arrayTest;
    }
}
