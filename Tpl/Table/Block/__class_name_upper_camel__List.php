<?php
namespace {:namespace}\Block;


use {:namespace}\Api\Data\{:class_name_upper_camel}Interface;
use {:namespace}\Model\ResourceModel\{:class_name_upper_camel}\Collection as {:class_name_upper_camel}Collection;


class {:class_name_upper_camel}List extends \Magento\Framework\View\Element\Template implements
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
        $this->pageConfig->getTitle()->set(__('List {:module_name_title}s'));
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


    protected function _prepareLayout()
    {
        parent::_prepareLayout();
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
        return $this;
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
        return $this->getUrl('*/view/index', ['id'=>${:class_name_lower}->get{:table_primary_key_upper_camel}()]);
    }

    /**
     * @return string
     */
    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }

}
