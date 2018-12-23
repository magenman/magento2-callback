<?php
namespace Magenman\CallToOrder\Controller\Adminhtml\Manager;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Index
 * @package Magenman\CallToOrder\Controller\Adminhtml\Manager
 */
class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * Index constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Magenman_CallToOrder::Manager');
        $resultPage->addBreadcrumb(__('Manage Call Backs'), __('Manage Call Backs'));
        $resultPage->addBreadcrumb(__('Call Back Manager'), __('Call Back Manager'));
        $resultPage->getConfig()->getTitle()->prepend(__('Call Back Manager'));
        return $resultPage;
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return true;
    }
}
