<?php
namespace {:namespace}\Block\{:class_name_upper_camel};

use Magento\Store\Model\ScopeInterface;

class View extends \Magento\Framework\View\Element\Template implements
    \Magento\Framework\DataObject\IdentityInterface
{

    /**
     * Construct
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \{:namespace}\Model\{:class_name_upper_camel} ${:class_name_lower}
     * @param \{:namespace}\Model\{:class_name_upper_camel}Factory ${:class_name_lower}Factory
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \{:namespace}\Model\{:class_name_upper_camel} ${:class_name_lower},
        \{:namespace}\Model\{:class_name_upper_camel}Factory ${:class_name_lower}Factory,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->_{:class_name_lower} = ${:class_name_lower};
        $this->_{:class_name_lower}Factory = ${:class_name_lower}Factory;
    }

    /**
     * @return \{:namespace}\Model\{:class_name_upper_camel}
     */
    public function get{:class_name_upper_camel}()
    {
        // Check if {:class_name_lower}s has already been defined
        // makes our block nice and re-usable! We could
        // pass the '{:class_name_lower}s' data to this block, with a collection
        // that has been filtered differently!
        if (!$this->hasData('{:class_name_lower}')) {
            if ($this->get{:table_primary_key_upper_camel}()) {
                /** @var \{:namespace}\Model\Post $page */
                ${:class_name_lower} = $this->_{:class_name_lower}Factory->create();
            } else {
                ${:class_name_lower} = $this->_{:class_name_lower};
            }
            $this->setData('{:class_name_lower}', ${:class_name_lower});
        }
        return $this->getData('{:class_name_lower}');
    }

    /**
     * Return identifiers for produced content
     *
     * @return array
     */
    public function getIdentities()
    {
        return [\{:namespace}\Model\{:class_name_upper_camel}::CACHE_TAG . '_' . $this->get{:class_name_upper_camel}()->get{:table_primary_key_upper_camel}()];
    }

    /**
     * Prepare global layout
     *
     * @return $this
     */
    protected function _prepareLayout()
    {
        ${:class_name_lower} = $this->get{:class_name_upper_camel}();
        $this->_addBreadcrumbs(${:class_name_lower});
        $this->pageConfig->addBodyClass('pointofsale');
        //$this->pageConfig->getTitle()->set(${:class_name_lower}->getTitle());
        //$this->pageConfig->setDescription(${:class_name_lower}->getDescription());
        $this->pageConfig->getTitle()->set(__('View {:module_name_title}'));
        return parent::_prepareLayout();
    }



    /**
     * Prepare breadcrumbs
     *
     * @param \{:namespace}\Model\{:class_name_upper_camel} ${:class_name_lower}
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return void
     */
    protected function _addBreadcrumbs(\{:namespace}\Model\{:class_name_upper_camel} ${:class_name_lower})
    {
        if ($this->_scopeConfig->getValue('web/default/show_pointofsale_shop_breadcrumbs', ScopeInterface::SCOPE_STORE)
                && ($breadcrumbsBlock = $this->getLayout()->getBlock('breadcrumbs'))
        ) {
            $breadcrumbsBlock->addCrumb(
                    'home',
                    [
                    'label' => __('Home'),
                    'title' => __('Go to Home Page'),
                    'link' => $this->_storeManager->getStore()->getBaseUrl()
                    ]
            );
            $breadcrumbsBlock->addCrumb('{:route_name}', ['label' => __('{:module_name_title}s List'), 'title' => __('{:module_name_title}s List'), 'link' => $this->getUrl('{:route_name}/{:class_name_lower}')]);
            //$breadcrumbsBlock->addCrumb('pointofsale_shop', ['label' => ${:class_name_lower}->getTitle(), 'title' => ${:class_name_lower}->getTitle()]);
            $breadcrumbsBlock->addCrumb('pointofsale_shop', ['label' => __('View {:module_name_title}'), 'title' => __('View {:module_name_title}')]);
        }
    }

}
