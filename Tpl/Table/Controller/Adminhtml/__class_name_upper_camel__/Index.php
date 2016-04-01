<?php
namespace {:namespace}\Controller\Adminhtml\{:class_name_upper_camel};

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Backend\App\Action
{

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
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
     * Index action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('{:module_name}::{:route_name}');
        $resultPage->addBreadcrumb(__('{:module_name_title} {:class_name_upper_camel}s'), __('{:module_name_title} {:class_name_upper_camel}s'));
        $resultPage->addBreadcrumb(__('Manage {:module_name_title} {:class_name_upper_camel}s'), __('Manage {:module_name_title} {:class_name_upper_camel}s'));
        $resultPage->getConfig()->getTitle()->prepend(__('{:module_name_title} {:class_name_upper_camel}s'));

        return $resultPage;
    }

    /**
     * Is the user allowed to view the {:module_name} {:class_name_lower} grid.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('{:module_name}::{:class_name_lower}');
    }


}
