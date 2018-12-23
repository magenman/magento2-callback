<?php
namespace Magenman\CallToOrder\Controller\Adminhtml\Report;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Index
 * @package Magenman\CallToOrder\Controller\Adminhtml\Report
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
        $resultPage->setActiveMenu('Magenman_CallToOrder::report_manager');
        $resultPage->addBreadcrumb(__('Report for admin'), __('Report for admin'));
        $resultPage->addBreadcrumb(__('Report for admin'), __('Report for admin'));
        $resultPage->getConfig()->getTitle()->prepend(__('Report Call To Order'));

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
