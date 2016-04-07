<?php
namespace {:namespace}\Controller\{:class_name_upper_camel};

use \Magento\Framework\App\Action\Action;

class View extends Action
{
    /** @var  \Magento\Framework\Controller\Result\ForwardFactory */
    protected $resultForwardFactory;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     */
    public function __construct(\Magento\Framework\App\Action\Context $context,
                                \Magento\Framework\Controller\Result\ForwardFactory $resultForwardFactory
    )
    {
        $this->resultForwardFactory = $resultForwardFactory;
        parent::__construct($context);
    }

    /**
     *
     * @return \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
        ${:table_primary_key} = $this->getRequest()->getParam('{:table_primary_key}', $this->getRequest()->getParam('id', false));
        /** @var \{:namespace}\Helper\{:class_name_upper_camel} ${:class_name_lower}_helper */
        ${:class_name_lower}_helper = $this->_objectManager->get('{:namespace}\Helper\{:class_name_upper_camel}');
        $result_page = ${:class_name_lower}_helper->prepareResult{:class_name_upper_camel}($this, ${:table_primary_key});
        if (!$result_page) {
            $resultForward = $this->resultForwardFactory->create();
            return $resultForward->forward('noroute');
        }
        return $result_page;
    }
}