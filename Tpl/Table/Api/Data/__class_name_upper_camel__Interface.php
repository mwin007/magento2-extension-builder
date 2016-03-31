<?php
namespace {:namespace}\Api\Data;

interface {:class_name_upper_camel}Interface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    {:LOOP_COLS
    const {:column_name_upper} = '{:column_name}';
    LOOP_COLS}

    {:LOOP_COLS
    /**
     * Get {:column_name}
     *
     * @return {:column_type}|null
     */
    public function get{:column_name_camel}();


    /**
     * Set {:column_name}
     *
     * @param {:column_type} ${:column_name}
     * @return {:namespace}\{:class_name_upper_camel}Interface
     */
    public function set{:column_name_camel}(${:column_name});
    LOOP_COLS}

}
