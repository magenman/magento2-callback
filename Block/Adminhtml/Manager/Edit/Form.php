<?php

namespace Magenman\CallToOrder\Block\Adminhtml\Manager\Edit;

/**
 * Class Form
 *
 * @package Magenman\CallToOrder\Block\Adminhtml\Manager\Edit
 */
class Form extends \Magento\Backend\Block\Widget\Form\Generic
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;

    /**
     * @var \Magenman\CallToOrder\Model\Status
     */
    protected $_status;

    /**
     * @var \Magenman\CallToOrder\Model\TemplateFactory
     */
    protected $_templateEmail;

    /**
     * Form constructor.
     *
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Store\Model\System\Store $systemStore
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        \Magenman\CallToOrder\Model\Status $status,
        \Magenman\CallToOrder\Model\TemplateFactory $templateFactory,
        array $data = []
    ) {
        $this->_systemStore = $systemStore;
        $this->_templateEmail = $templateFactory;
        $this->_status = $status;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Init form
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('manager_form');
        $this->setTitle(__('CallToOrder Information'));
    }

    /**
     * Prepare form
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        /** @var \Magenman\CallToOrder\Model\Manager $model */
        $model = $this->_coreRegistry->registry('manager');

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(
            ['data' => ['id' => 'edit_form', 'action' => $this->getData('action'), 'method' => 'post','enctype' => 'multipart/form-data']]
        );

        $form->setHtmlIdPrefix('calltoorder_');
        $id = $this->_request->getParam('id');

        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('General Information'), 'class' => 'fieldset-wide']
        );

        if (isset($id)) {
            $model['calltoorder_id'] = $id;
            $fieldset->addField('calltoorder_id', 'hidden', ['name' => 'calltoorder_id']);
        }

        $fieldset->addField(
            'name',
            'text',
            ['name' => 'name', 'label' => __('Name User'), 'title' => __('Name User'), 'required' => true]
        );
        $fieldset->addField(
            'email',
            'text',
            ['name' => 'email', 'label' => __('Email'), 'title' => __('Email'), 'required' => true]
        );

        $fieldset->addField(
            'phone',
            'text',
            ['name' => 'phone', 'label' => __('Phone'), 'title' => __('Phone'), 'required' => true]
        );
        $fieldset->addField(
            'product_name',
            'text',
            ['name' => 'product_name', 'label' => __('Product Name'), 'title' => __('Product Name'), 'required' => true]
        );
        $fieldset->addField(
            'template',
            'select',
            [
                'label' => __('Template'),
                'title' => __('Template'),
                'name' => 'template',
                'required' => true,
                'options' => $this->getTemplateOption()
            ]
        );
        $fieldset->addField(
            'note',
            'text',
            ['name' => 'note', 'label' => __('Note'), 'title' => __('Note'), 'required' => true]
        );
        $fieldset->addField(
            'status',
            'select',
            [
                'label' => __('Status'),
                'title' => __('Status'),
                'name' => 'status',
                'required' => true,
                'options' => $this->_status->getOptionArray(),
            ]
        );

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * @return array
     */
    public function getTemplateOption()
    {
        $model = $this->_templateEmail->create()->getCollection();
        $resutl = [];
        foreach ($model as $data) {
            $resutl[$data->getId()] = $data->getTemplate();
        }

        return $resutl;
    }
}
