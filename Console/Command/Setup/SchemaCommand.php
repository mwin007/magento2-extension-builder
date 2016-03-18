<?php

namespace ADM\DevBuilder\Console\Command\Setup;

use ADM\DevBuilder\Console\Command\AbstractTplCommand;

class SchemaCommand extends AbstractTplCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('dev:builder:schema');
        $this->setDescription('Create InstallSchema class');

        parent::configure();
    }

    /**
     * {@inheritdoc}
     */
    protected function processTemplate($table, $describe, $namespace)
    {
        $classFull = [];

        $namespace.='\Setup';

        $classFull[] = $this->getClassHead(['table_name'=>$table,
                 'namespace'=> $namespace]);

        foreach ($describe as $column => $row) {
            $classFull[] = $this->getAddColumn(['column_name'=>$column,
                    'column_type'=>$this->getMagentoType($row['DATA_TYPE']),
                    'column_length'=>$this->getMagentoSize($row),
                    'column_constraints'=>$this->getMagentoConstraints($row),
                    ]);
        }

        $classFull[] = $this->getClassFoot(['table_name'=>$table]);


        return $classFull;
    }

    protected function getClassHead($replace)
    {

        $classPhpHead = "
use {:namespace}

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface \$setup, ModuleContextInterface \$context)
    {
        \$installer = \$setup;

        \$installer->startSetup();
        /**
         * Create table '{:table_name}'
         */
        \$table = \$installer->getConnection()
        ->newTable(\$installer->getTable('{:table_name}'))";

        return $this->getSearchReplace($classPhpHead, $replace);
    }

    protected function getAddColumn($replace)
    {
        $classPhpColumn = "        ->addColumn(
                '{:column_name}',
                \Magento\Framework\DB\Ddl\Table::{:column_type},
                {:column_length},
                [{:column_constraints}],
                '{:column_name}'
        )";


        return $this->getSearchReplace($classPhpColumn, $replace);
    }

    protected function getClassFoot($replace)
    {
        $classPhpFoot = "        ->setComment('{:table_name}');
        \$installer->getConnection()->createTable(\$table);

        \$setup->endSetup();
    }
}";

        return $this->getSearchReplace($classPhpFoot, $replace);
    }

    protected function getMagentoType($type) {

        $mageType = ['smallint'=>'TYPE_SMALLINT',
        'int'=>'TYPE_INTEGER',
        'varchar'=>'TYPE_TEXT',
        'text'=>'TYPE_TEXT',
        'decimal'=>'TYPE_DECIMAL',
        'timestamp'=>'TYPE_TIMESTAMP',
        'date'=>'TYPE_DATE',
        ];

        return $mageType[$type];
    }

    protected function getMagentoSize($row) {

        switch ($row['DATA_TYPE']) {
            case 'text':
                $size = "'64k'";
                break;
            case 'decimal':
                $size = $row['PRECISION'].','.$row['SCALE'];
                break;
            default:
                $size = is_null($row['LENGTH']) ? 'null' : $row['LENGTH'];
                break;
        }


        return $size;
    }

    protected function getMagentoConstraints($row) {
        $mapDefault = [];
        $mapDefault['CURRENT_TIMESTAMP'] = '\Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT';

        $constraints = [];
        if(!empty($row['IDENTITY'])) {
            $constraints[] = "'identity' => true";
        }
        if(!empty($row['PRIMARY'])) {
            $constraints[] = "'primary' => true";
        }
        if(!empty($row['UNSIGNED'])) {
            $constraints[] = "'unsigned' => true";
        }
        if(empty($row['NULLABLE'])) {
            $constraints[] = "'nullable' => false";
        }
        if(isset($row['DEFAULT'])) {

            if(!empty($mapDefault[$row['DEFAULT']])) {
                $constraints[] = "'default' => '".$mapDefault[$row['DEFAULT']]."'";
            } else {
                $constraints[] = "'default' => '".$row['DEFAULT']."'";
            }

        }

        return implode(', ', $constraints);
    }
}