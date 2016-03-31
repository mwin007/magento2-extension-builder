<?php

namespace {:namespace}\Model;

use {:namespace}\Api\Data\{:class_name_upper_camel}Interface;
use Magento\Framework\DataObject\IdentityInterface;

class {:class_name_upper_camel} extends \Magento\Framework\Model\AbstractModel
implements {:class_name_upper_camel}Interface, IdentityInterface
{
    /**
     * CMS page cache tag
     */
    const CACHE_TAG = '{:cache_tag}';

    /**
     * @var string
     */
    protected $_cacheTag = '{:cache_tag}';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = '{:prefix}';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('{:namespace}\Model\ResourceModel\{:class_name_upper_camel}');
    }

    /**
     * Return unique ID(s) for each object in system
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->get{:table_primary_key_upper_camel}()];
    }


    {:LOOP_COLS
    /**
     * Get {:column_name}
    *
    * @return {:column_type}|null
    */
    public function get{:column_name_camel}()
    {
        return $this->getData(self::{:column_name_upper});
    }


    /**
     * Set {:column_name}
     *
     * @param {:column_type} ${:column_name}
     * @return {:namespace}\{:class_name_upper_camel}Interface
     */
    public function set{:column_name_camel}(${:column_name})
    {
        return $this->setData(self::{:column_name_upper}, ${:column_name});
    }
    LOOP_COLS}
}