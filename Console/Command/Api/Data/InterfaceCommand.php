<?php

namespace ADM\DevBuilder\Console\Command\Api\Data;

use ADM\DevBuilder\Console\Command\AbstractTplCommand;
use Magento\Framework\Api\SimpleDataObjectConverter;

class InterfaceCommand extends AbstractTplCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('dev:builder:interface');
        $this->setDescription('Create api interface class');

        parent::configure();
    }

    /**
     * {@inheritdoc}
     */
    protected function processTemplate($table, $describe, $namespace)
    {
        $classFull = [];

        $namespace.='\Api\Data';

        $classFull[] = $this->getClassHead(['class_name'=>SimpleDataObjectConverter::snakeCaseToUpperCamelCase($table),
                'namespace'=> $namespace]);

        foreach ($describe as $column => $row) {
            $classFull[] = $this->getClassConst($column);
        }

        foreach ($describe as $column => $row) {
            $classFull[] = $this->getClassMethod(['column_name'=>$column,
                    'column_camel_name'=>SimpleDataObjectConverter::snakeCaseToUpperCamelCase($column),
                    'column_type'=>$this->getMagentoType($row['DATA_TYPE']),
                    'namespace'=> $namespace,
                    'class_name'=>SimpleDataObjectConverter::snakeCaseToUpperCamelCase($table)
                    ]);
        }

        $classFull[] = $this->getClassFoot(['table_name'=>$table]);


        return $classFull;
    }

    protected function getClassHead($replace)
    {

        $classPhpHead = "
use {:namespace}

interface {:class_name}Interface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
        ";

        return $this->getSearchReplace($classPhpHead, $replace);
    }

    protected function getClassConst($column)
    {
        $classPhpColumn = "    const ". str_pad($this->constName($column), 20, ' ') . "= '" . $column . "';";

        return $classPhpColumn;
    }

    protected function constName($column)
    {
        return strtoupper($column);
    }



    protected function getClassMethod($replace)
    {
        $classPhpMethod = "
    /**
     * Get {:column_name}
     *
     * @return {:column_type}|null
     */
    public function get{:column_camel_name}();


    /**
     * Set {:column_name}
     *
     * @param {:column_type} \${:column_name}
     * @return {:namespace}\{:class_name}Interface
     */
    public function set{:column_camel_name}(\${:column_name});

        ";


        return $this->getSearchReplace($classPhpMethod, $replace);
    }

    protected function getClassFoot($replace)
    {
        $classPhpFoot = "
}";

        return $this->getSearchReplace($classPhpFoot, $replace);
    }

    protected function getMagentoType($type) {

        $mageType = ['smallint'=>'int',
        'varchar'=>'string',
        'text'=>'string',
        'decimal'=>'decimal',
        'timestamp'=>'string',
        'date'=>'string',
        ];

        return $mageType[$type];
    }



}
