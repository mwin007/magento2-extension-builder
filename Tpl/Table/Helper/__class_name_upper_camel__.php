<?php

namespace {:namespace}\Helper;

use Magento\Framework\App\Action\Action;

class {:class_name_upper_camel} extends \Magento\Framework\App\Helper\AbstractHelper
{

    /**
     * @var \{:namespace}\Model\{:class_name_upper_camel}
     */
    protected $_{:class_name_lower};

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * Constructor
     *
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \{:namespace}\Model\{:class_name_upper_camel} ${:class_name_lower}
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
            \Magento\Framework\App\Helper\Context $context,
            \{:namespace}\Model\{:class_name_upper_camel} ${:class_name_lower},
            \Magento\Framework\View\Result\PageFactory $resultPageFactory
    )
    {
        $this->_{:class_name_lower} = ${:class_name_lower};
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * Return a blog {:class_name_lower} from given {:class_name_lower} id.
     *
     * @param Action $action
     * @param null ${:table_primary_key_camel}
     * @return \Magento\Framework\View\Result\Page|bool
     */
    public function prepareResult{:class_name_upper_camel}(Action $action, ${:table_primary_key_camel}= null)
    {
        if (${:table_primary_key_camel} !== null && ${:table_primary_key_camel} !== $this->_{:class_name_lower}->get{:table_primary_key_upper_camel}()) {
            $delimiterPosition = strrpos(${:table_primary_key_camel}, '|');
            if ($delimiterPosition) {
                ${:table_primary_key_camel} = substr(${:table_primary_key_camel}, 0, $delimiterPosition);
            }

            if (!$this->_{:class_name_lower}->load(${:table_primary_key_camel})) {
                return false;
            }
        }

        if (!$this->_{:class_name_lower}->get{:table_primary_key_upper_camel}()) {
            return false;
        }

        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        // We can add our own custom page handles for layout easily.
        $resultPage->addHandle('{:route_name}_{:class_name_lower}_view');

        // This will generate a specific layout handle like: {:route_name}_{:class_name_lower}_view_id_1
        // giving us a unique handle to target specific {:route_name} {:class_name_lower}s if we wish to.
        $resultPage->addPageLayoutHandles(['id' => $this->_{:class_name_lower}->get{:table_primary_key_upper_camel}()]);

        // Magento is event driven after all, lets remember to dispatch our own, to help people
        // who might want to add additional functionality, or filter the {:class_name_lower}s somehow!
        $this->_eventManager->dispatch(
                '{:module_name_lower}_{:class_name_lower}_render',
                ['{:class_name_lower}' => $this->_{:class_name_lower}, 'controller_action' => $action]
        );

        return $resultPage;
    }
}