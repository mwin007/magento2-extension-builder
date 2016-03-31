<?php

namespace {:namespace}\Model\ResourceModel\{:class_name_upper_camel};

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = '{:table_primary_key}';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('{:namespace}\Model\{:class_name_upper_camel}', '{:namespace}\Model\ResourceModel\{:class_name_upper_camel}');
    }

}