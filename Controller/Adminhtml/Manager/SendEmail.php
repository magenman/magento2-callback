<?php

namespace Magenman\CallToOrder\Controller\Adminhtml\Manager;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Psr\Log\LoggerInterface;
use Magenman\CallToOrder\Model\ManagerFactory;
use Magenman\CallToOrder\Model\TemplateFactory;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Area;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Translate\Inline\StateInterface;

/**
 * Class SendEmail
 * @package Magenman\CallToOrder\Controller\Adminhtml\Manager
 */
class SendEmail extends Action
{
    /**
     * Const Email
     */
    const XML_PATH_EMAIL_SENDER = 'trans_email/ident_general/email';

    /**
     * Const Name
     */
    const XML_PATH_NAME_SENDER = 'trans_email/ident_general/name';
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var ManagerFactory
     */
    protected $manager;

    /**
     * @var TemplateFactory
     */
    protected $template;

    /**
     * @var TransportBuilder
     */
    protected $_transportBuilder;

    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @var StateInterface
     */
    protected $inlineTranslation;

    /**
     * SendMail constructor.
     * @param Context $context
     * @param LoggerInterface $loggerInterface
     * @param ManagerFactory $managerFactory
     * @param TemplateFactory $templateFactory
     */
    public function __construct(
        Context $context,
        LoggerInterface $loggerInterface,
        ManagerFactory $managerFactory,
        TemplateFactory $templateFactory,
        TransportBuilder $transportBuilder,
        StoreManagerInterface $storeManager,
        ScopeConfigInterface $scopeConfig,
        StateInterface $inlineTranslation
    ) {
        parent::__construct($context);
        $this->logger = $loggerInterface;
        $this->manager = $managerFactory;
        $this->template = $templateFactory;
        $this->_transportBuilder = $transportBuilder;
        $this->_storeManager = $storeManager;
        $this->_scopeConfig = $scopeConfig;
        $this->inlineTranslation = $inlineTranslation;
    }

    /**
     * @return $this
     */
    public function execute()
    {
        $resultPage = $this->resultRedirectFactory->create();
        $id = (int)$this->getRequest()->getParam('id');

        if ($id) {
            $this->sendMail($id);
        }

        return $resultPage->setPath('calltoorder/manager/index');
    }

    /**
     * @param $id
     */
    private function sendMail($id)
    {
        $modelManager = $this->manager->create()->load($id);
        $modelTemplate = $this->template->create()->load($modelManager->getTemplate());
        $transport = $this->_transportBuilder->setTemplateIdentifier('calltoorder_email_template')->setTemplateOptions(
            [
                'area' => Area::AREA_FRONTEND,
                'store' => $this->_storeManager->getStore()->getId(),
            ]
        )->setTemplateVars(
            [
                'store' => $this->_storeManager->getStore(),
                'store URL' => $this->_storeManager->getStore()->getBaseUrl(),
                'content' => $modelTemplate->getSubject(),
                'product' => $modelManager->getProductName()
            ]
        )->setFrom(
            [
                'email' => $this->_scopeConfig->getValue(self::XML_PATH_EMAIL_SENDER),
                'name' => $this->_scopeConfig->getValue(self::XML_PATH_NAME_SENDER)
            ]
        )->addTo(
            $modelManager->getEmail(),
            $modelManager->getName()
        )->getTransport();
        $transport->sendMessage();
        $this->inlineTranslation->resume();
    }

    /**
     * Check ACL
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('CallToOrder_Manager::manager');
    }
}
