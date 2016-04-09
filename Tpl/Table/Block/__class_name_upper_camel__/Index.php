<?php
namespace {:namespace}\Block\{:class_name_upper_camel};

use Magento\Store\Model\ScopeInterface;
use {:namespace}\Api\Data\{:class_name_upper_camel}Interface;
use {:namespace}\Model\ResourceModel\{:class_name_upper_camel}\Collection as {:class_name_upper_camel}Collection;


class Index extends \Magento\Framework\View\Element\Template implements
\Magento\Framework\DataObject\IdentityInterface
{
    /**
     * @var \{:namespace}\Model\ResourceModel\{:class_name_upper_camel}Factory
     */
    protected $_{:class_name_camel}CollectionFactory;

    /**
     * Construct
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \{:namespace}\Model\ResourceModel\{:class_name_upper_camel}\CollectionFactory ${:class_name_camel}CollectionFactory,
     * @param array $data
     */
    public function __construct(
            \Magento\Framework\View\Element\Template\Context $context,
            \{:namespace}\Model\ResourceModel\{:class_name_upper_camel}\CollectionFactory ${:class_name_camel}CollectionFactory,
            array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_{:class_name_camel}CollectionFactory = ${:class_name_camel}CollectionFactory;
    }

    /**
     * @return \{:namespace}\Model\ResourceModel\{:class_name_upper_camel}\Collection
     */
    public function get{:class_name_upper_camel}s()
    {
        if (!$this->hasData('{:class_name_lower}s')) {
            ${:class_name_lower} = $this->_{:class_name_camel}CollectionFactory
            ->create();

            $this->setData('{:class_name_lower}s', ${:class_name_lower});
        }
        return $this->getData('{:class_name_lower}s');
    }


    /**
     * Return identifiers for produced content
     *
     * @return array
     */
    public function getIdentities()
    {
        return [\{:namespace}\Model\{:class_name_upper_camel}::CACHE_TAG . '_' . 'list'];
    }

    /**
     * @param object ${:class_name_lower}
     * @return string
     */
    public function getViewUrl(${:class_name_lower})
    {
        return $this->getUrl('{:route_name}/{:class_name_lower}/view', ['id'=>${:class_name_lower}->get{:table_primary_key_upper_camel}()]);
    }

    protected function _prepareLayout()
    {

        //Add pager
        if ($this->get{:class_name_upper_camel}s()) {
            $pager = $this->getLayout()->createBlock(
                    'Magento\Theme\Block\Html\Pager',
                    '{:class_name_lower}.grid.record.pager'
            )->setCollection(
                    $this->get{:class_name_upper_camel}s()
                    );
            $this->setChild('pager', $pager);
            $this->get{:class_name_upper_camel}s()->load();
        }

        $this->_addBreadcrumbs();
        $this->pageConfig->addBodyClass('{:route_name}');
        $this->pageConfig->getTitle()->set(__('{:module_name_title}s List'));
        $this->pageConfig->setDescription(__('{:module_name_title}s List'));

        return parent::_prepareLayout();
    }


    /**
     * @return string
     */
    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }

    /**
     * Prepare breadcrumbs
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return void
     */
    protected function _addBreadcrumbs()
    {
        if ($this->_scopeConfig->getValue('web/default/show_{:route_name}_{:class_name_lower}_breadcrumbs', ScopeInterface::SCOPE_STORE)
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
        }
    }

}
