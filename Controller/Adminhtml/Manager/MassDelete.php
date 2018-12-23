<?php

namespace Magenman\CallToOrder\Controller\Adminhtml\Manager;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\ResultFactory;
use Magenman\CallToOrder\Model\ResourceModel\Manager\CollectionFactory as ManagerCollectionFactory;
use Magenman\CallToOrder\Controller\Adminhtml\Manager as ManagerController;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Backend\Model\View\Result\ForwardFactory;

/**
 * Class MassDelete
 * @package Magenman\CallToOrder\Controller\Adminhtml\Manager
 */
class MassDelete extends ManagerController
{
    /**
     * @var Filter
     */
    protected $_filter;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $_logger;
    /**
     * @var \Magento\Backend\Model\View\Result\ForwardFactory
     */
    protected $resultForwardFactory;

    /**
     * @var \Magenman\CallToOrder\Model\ManagerFactory
     */
    protected $manager;

    /**
     * MassDelete constructor.
     * @param Context $context
     * @param Registry $coreRegistry
     * @param PageFactory $resultPageFactory
     * @param ManagerCollectionFactory $collectionFactory
     * @param Filter $filter
     * @param ForwardFactory $resultForwardFactory
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        PageFactory $resultPageFactory,
        ManagerCollectionFactory $collectionFactory,
        Filter $filter,
        ForwardFactory $resultForwardFactory,
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
     * @return mixed
     */
    public function execute()
    {
        $data = $this->_request->getParams();
        $array = $data['selected'];
        $totals = 0;
        try {
            foreach ($array as $item) {
                $model = $this->manager->create()->load($item);
                $model->delete();
                $totals++;
            }
            $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been deteled.', $totals));
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->_getSession()->addException($e, __('Something went wrong while delete the post(s).'));
        }
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        
        return $resultRedirect->setPath('*/*/');
    }
}
