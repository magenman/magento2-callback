<?php

namespace Magenman\CallToOrder\Controller\Adminhtml\Manager;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Magenman\CallToOrder\Model\ResourceModel\Manager\CollectionFactory as ManagerCollectionFactory;
use Magenman\CallToOrder\Controller\Adminhtml\Manager as ManagerController;
use Magento\Ui\Component\MassAction\Filter;

/**
 * Class MassStatus
 *
 * @package Magenman\CallToOrder\Controller\Adminhtml\Manager
 */

class MassStatus extends ManagerController
{
    /**
     * @var Filter
     */
    protected $_logger;

    /**
     * @var Filter
     */
    protected $_filter;

    /**
     * @var \Magento\Backend\Model\View\Result\ForwardFactory
     */
    protected $resultForwardFactory;

    /**
     * MassStatus constructor.
     * @param Context $context
     * @param Registry $coreRegistry
     * @param PageFactory $resultPageFactory
     * @param ManagerCollectionFactory $collectionFactory
     * @param Filter $filter
     * @param \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        PageFactory $resultPageFactory,
        ManagerCollectionFactory $collectionFactory,
        Filter $filter,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory,
        \Psr\Log\LoggerInterface $loggerInterface,
        \Magenman\CallToOrder\Model\ManagerFactory $managerFactory
    ) {
        $this->_logger = $loggerInterface;
        $this->manager = $managerFactory;
        $this->_filter = $filter;
        $this->resultForwardFactory = $resultForwardFactory;
        parent::__construct($context, $coreRegistry, $resultPageFactory, $collectionFactory);
    }

    /**
     * @return $this
     */
    public function execute()
    {
        $data = $this->_request->getParams();
        $array = $data['selected'];
        $status = (int) $this->getRequest()->getParam('status');
        $totals = 0;
        try {
            foreach ($array as $item) {

                /** @var \Magenman\CallToOrder\Model\ResourceModel\Manager\Collection $item */
                $model = $this->manager->create()->load($item);
                $model->setStatus($status)->save();
                $totals++;
            }
            $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been updated.', $totals));
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }
        $resultRedirect = $this->resultRedirectFactory->create();

        return $resultRedirect->setPath('*/*');
    }
}
