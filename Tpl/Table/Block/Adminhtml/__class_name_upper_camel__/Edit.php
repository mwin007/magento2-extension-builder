<?php
namespace {:namespace}\Block\Adminhtml\{:class_name_upper_camel};


class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
            \Magento\Backend\Block\Widget\Context $context,
            \Magento\Framework\Registry $registry,
            array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * Initialize {:route_name} {:class_name_lower} edit block
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId = '{:table_primary_key}';
        $this->_blockGroup = '{:module_name}';
        $this->_controller = 'adminhtml_{:class_name_lower}';

        parent::_construct();

        if ($this->_isAllowedAction('{:module_name}::save')) {
            $this->buttonList->update('save', 'label', __('Save {:module_name_title} {:class_name_upper_camel}'));
            $this->buttonList->add(
                    'saveandcontinue',
                    [
                    'label' => __('Save and Continue Edit'),
                    'class' => 'save',
                    'data_attribute' => [
                    'mage-init' => [
                    'button' => ['event' => 'saveAndContinueEdit', 'target' => '#edit_form'],
                    ],
                    ]
                    ],
                    -100
            );
        } else {
            $this->buttonList->remove('save');
        }

        if ($this->_isAllowedAction('{:module_name}::{:class_name_lower}_delete')) {
            $this->buttonList->update('delete', 'label', __('Delete {:class_name_upper_camel}'));
        } else {
            $this->buttonList->remove('delete');
        }
    }

    /**
     * Retrieve text for header element depending on loaded {:class_name_lower}
     *
     * @return \Magento\Framework\Phrase
     */
    public function getHeaderText()
    {
        if ($this->_coreRegistry->registry('{:route_name}_{:class_name_lower}')->getId()) {
            return __("Edit {:class_name_upper_camel} '%1'", $this->escapeHtml($this->_coreRegistry->registry('{:route_name}_{:class_name_lower}')->getTitle()));
        } else {
            return __('New {:class_name_upper_camel}');
        }
    }

    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }

    /**
     * Getter of url for "Save and Continue" button
     * tab_id will be replaced by desired by JS later
     *
     * @return string
     */
    protected function _getSaveAndContinueUrl()
    {
        return $this->getUrl('{:route_name}/*/save', ['_current' => true, 'back' => 'edit', 'active_tab' => '']);
    }
}