<?php
namespace Magenman\CallToOrder\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Magenman\CallToOrder\Model\ResourceModel\Manager\CollectionFactory as PostCollectionFactory;

/**
 * Reviews admin controller
 */
abstract class Manager extends Action
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry = null;

    /**
     * @var PostCollectionFactory
     */
    protected $_collectionFactory;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var Action\Context
     */
    protected $_context;

    /**
     * Manager constructor.
     *
     * @param Action\Context $context
     * @param Registry $coreRegistry
     * @param PageFactory $resultPageFactory
     * @param PostCollectionFactory $collectionFactory
     */
    public function __construct(
        Action\Context $context,
        Registry $coreRegistry,
        PageFactory $resultPageFactory,
        PostCollectionFactory $collectionFactory
    ) {
        $this->_context = $context;
        $this->coreRegistry = $coreRegistry;
        $this->_collectionFactory = $collectionFactory;
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * Init actions
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function _initAction()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('CallToOrder_Manager::manager')
            ->addBreadcrumb(__('Call To Order'), __('Call To Order'));
        $resultPage->getConfig()->getTitle()->set(__('Call Back Manager'));

        return $resultPage;
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('CallToOrder_Manager::manager');
    }
}
