<?php
namespace {:namespace}\Block\Adminhtml\{:class_name_upper_camel}\Edit;

class Form extends \Magento\Backend\Block\Widget\Form\Generic
{

    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig
     * @param \Magento\Store\Model\System\Store $systemStore
     * @param array $data
     */
    public function __construct(
            \Magento\Backend\Block\Template\Context $context,
            \Magento\Framework\Registry $registry,
            \Magento\Framework\Data\FormFactory $formFactory,
            \Magento\Store\Model\System\Store $systemStore,
            array $data = []
    ) {
        $this->_systemStore = $systemStore;
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
        $this->setId('{:class_name_lower}_form');
        $this->setTitle(__('{:class_name_upper_camel} Information'));
    }

    /**
     * Prepare form
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        /** @var \Ashsmith\Blog\Model\{:class_name_upper_camel} $model */
        $model = $this->_coreRegistry->registry('{:route_name}_{:class_name_lower}');

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(
                ['data' => ['id' => 'edit_form', 'action' => $this->getData('action'), 'method' => '{:class_name_lower}']]
        );

        $form->setHtmlIdPrefix('{:class_name_lower}_');

        $fieldset = $form->addFieldset(
                'base_fieldset',
                ['legend' => __('General Information'), 'class' => 'fieldset-wide']
        );

        {:LOOP_COLS
        $fieldset->addField(
                '{:column_name}',
                'text',
                ['name' => '{:column_name}', 'label' => __('{:column_name_title}'), 'title' => __('{:column_name_title}'), 'required' => {:column_is_required}]
        );
        LOOP_COLS}
        // Remove field auto generated
        $fieldset->removeField('{:table_primary_key}');

         if ($model->get{:table_primary_key_upper_camel}()) {
             $fieldset->addField('{:table_primary_key}', 'hidden', ['name' => '{:table_primary_key}']);
         }

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}