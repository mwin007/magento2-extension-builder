<?php
namespace {:namespace}\Block;


class {:class_name_upper_camel}View extends \Magento\Framework\View\Element\Template implements
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

}
