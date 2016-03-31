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
    }

    /**
     * @return \{:namespace}\Model\ResourceModel\{:class_name_upper_camel}\Collection
     */
    public function get{:class_name_upper_camel}s()
    {
        if (!$this->hasData('{:class_name_lower}')) {
            ${:class_name_lower} = $this->_{:class_name_camel}CollectionFactory
            ->create();

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
        return [\{:namespace}\Model\{:class_name_upper_camel}::CACHE_TAG . '_' . 'list'];
    }

}
