<?php
namespace Magenman\CallToOrder\Controller\Product;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory as ResultJsonFactory;

/**
 * Class Save
 *
 * @package Magenman\CallToOrder\Controller\Product
 */
class Save extends \Magento\Framework\App\Action\Action
{
    /**
     * @var ResultJsonFactory
     */
    protected $resultJsonFactory;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var \Magento\Framework\App\State
     */
    protected $state;
    /**
     * Save constructor.
     *
     * @param Context $context
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param ResultJsonFactory $resultJsonFactory
     */
    public function __construct(
        Context $context,
        \Magento\Framework\App\State $state,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        ResultJsonFactory $resultJsonFactory
    ) {
        $this->storeManager = $storeManager;
        $this->state = $state;
        $this->resultJsonFactory = $resultJsonFactory;
        parent::__construct($context);
    }

    /**
     * @return $this
     */
    public function execute()
    {
        $data = $this->_getDataJson();
        $resultJson = $this->resultJsonFactory->create();

        return $resultJson->setData($data);
    }

    /**
     * @return string
     */
    protected function _getDataJson()
    {
        $data = $this->getRequest()->getParams();
        $storeId = $this->getStoreIdCurrent();
        if ($data) {
            $array = [
                'name'          => $data['name'],
                'phone'         => $data['phone'],
                'email'         => $data['mail'],
                'product_id'    => $data['product_id'],
                'note'          => $data['note'],
                'store'         => $storeId,
                'product_name'  => $data['product_name'],
                'template'      => 1
            ];

            if (!empty($data['time1']) && $data['time1']!= 'undefined' && !empty($data['time2']) && $data['time2']!= 'undefined') {
                $array['time_to_call'] = 'from '.$data['time1'].'h to '.$data['time2'].'h';
            }
            $model = $this->_objectManager->create('Magenman\CallToOrder\Model\Manager')
            ->getCollection()->addFieldToFilter('email', $array['email'])
            ->addFieldToFilter('product_id', $array['product_id'])->getFirstItem();
            $model->addData($array);
            $model->save();
        }
        $result = 'Saved';

        return $result;
    }

    /**
     * @return int
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function getStoreIdCurrent()
    {
        if ($this->state->getAreaCode() == \Magento\Framework\App\Area::AREA_ADMINHTML) {
            // in admin area
            /** @var \Magento\Framework\App\RequestInterface $request */
            $request = $this->_request;
            $storeId = (int) $request->getParam('store', 0);
        } else {
            // frontend area
            $storeId = true; // get current store from the store resolver
        }

        $store = $this->storeManager->getStore($storeId);
        $websiteId = $store->getWebsiteId();

        return $websiteId;
    }
}
