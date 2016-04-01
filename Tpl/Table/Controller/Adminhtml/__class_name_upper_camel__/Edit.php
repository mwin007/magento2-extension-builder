<?php
namespace {:namespace}\Controller\Adminhtml\{:class_name_upper_camel};

use Magento\Backend\App\Action;

class Edit extends \Magento\Backend\App\Action
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
            Action\Context $context,
            \Magento\Framework\View\Result\PageFactory $resultPageFactory,
            \Magento\Framework\Registry $registry
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('{:module_name}::save');
    }

    /**
     * Init actions
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('{:module_name}::{:class_name_lower}')
        ->addBreadcrumb(__('{:module_name_title}'), __('{:module_name_title}'))
        ->addBreadcrumb(__('Manage {:module_name_title} {:class_name_upper_camel}s'), __('Manage {:module_name_title} {:class_name_upper_camel}s'));
        return $resultPage;
    }

    /**
     * Edit {:module_name_title} {:class_name_lower}
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('{:table_primary_key}');
        $model = $this->_objectManager->create('{:namespace}\Model\{:class_name_upper_camel}');

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This {:class_name_lower} no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath('*/*/');
            }
        }

        $data = $this->_objectManager->get('Magento\Backend\Model\Session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        $this->_coreRegistry->register('{:route_name}_{:class_name_lower}', $model);

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
                $id ? __('Edit {:module_name_title} {:class_name_upper_camel}') : __('New {:module_name_title} {:class_name_upper_camel}'),
                $id ? __('Edit {:module_name_title} {:class_name_upper_camel}') : __('New {:module_name_title} {:class_name_upper_camel}')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('{:module_name_title} {:class_name_upper_camel}s'));
        $resultPage->getConfig()->getTitle()
        ->prepend($model->getId() ? $model->getTitle() : __('New {:module_name_title} {:class_name_upper_camel}'));

        return $resultPage;
    }
}

