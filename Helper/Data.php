<?php
namespace ADM\DevBuilder\Helper;

use ADM\DevBuilder\Helper\Api\Data\InterfaceCommand;
use ADM\DevBuilder\Helper\Setup\SchemaCommand;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Component\ComponentRegistrar;
use Magento\Framework\Api\SimpleDataObjectConverter;


/**
 * Bundle helper
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    protected $_resource;

    protected $_filesystem;

    protected $_directoryWrite;

    protected $_directoryRead;

    protected $_componentRegistrar;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\ResourceConnection $resourceConnection,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Framework\Component\ComponentRegistrar $componentRegistrar
    ) {
        $this->_resource = $resourceConnection;
        $this->_filesystem = $filesystem;
        $this->_componentRegistrar = $componentRegistrar;

        $this->_directoryWrite = $this->_filesystem->getDirectoryWrite(DirectoryList::TMP);

        $this->_directoryRead = $this->_filesystem->getDirectoryRead(DirectoryList::ROOT);

        parent::__construct($context);
    }

    public function getDefaultRoutename($namespace)
    {
        return strtolower(str_replace('\\', '', $namespace));
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplate($mastertable, $table, $classname, $namespace, $routename, $print=false)
    {
        $writeMode = 'w';

        $replaceCommon = ['table_name'=>$table,
            'class_name_upper_camel'=>SimpleDataObjectConverter::snakeCaseToUpperCamelCase($classname),
            'class_name_upper'=>strtoupper($classname),
            'class_name_camel'=>SimpleDataObjectConverter::snakeCaseToCamelCase($classname),
            'class_name_lower'=>strtolower($classname),
            'class_name_lower_dash'=>str_replace('_', '-', strtolower($classname)),
            'cache_tag'=>strtolower($routename.'_'.$classname),
            'prefix'=>strtolower($routename.'_'.$classname),
            'namespace'=> $namespace,
            'module_name'=>str_replace('\\', '_', $namespace),
            'module_name_lower'=>strtolower(str_replace('\\', '_', $namespace)),
            'module_name_title'=>ucwords(str_replace('\\', ' ', $namespace)),
            'composer_name'=>str_replace('\\', '\\\\', $namespace),
            'repo_name'=>str_replace('\\', '-', $namespace),
            'route_name'=>$routename
        ];

        $describe = $this->_resource->getConnection()->describeTable($mastertable);
        $replaceCol = [];
        foreach ($describe as $column => $row) {
            $replaceCol[] = ['column_name'=>$column,
                'column_name_camel'=>SimpleDataObjectConverter::snakeCaseToUpperCamelCase($column),
                'column_name_upper'=>strtoupper($column),
                'column_name_lower_dash'=>str_replace('_', '-', strtolower($column)),
                'column_name_title'=>ucwords(str_replace('_', ' ', $column)),
                'column_type'=>self::getMagentoType($row['DATA_TYPE']),
                'column_dbtype'=>$this->getColumnType($row['DATA_TYPE']),
                'column_length'=>$this->getColumnLength($row),
                'column_constraints'=>$this->getColumnConstraints($row),
                'column_is_required'=>$this->getColumnIsRequired($row)
            ];
            if($this->getColumnIsPrimary($row)) {
                $replaceCommon['table_primary_key'] = $column;
                $replaceCommon['table_primary_key_upper_camel'] = SimpleDataObjectConverter::snakeCaseToUpperCamelCase($column);
                $replaceCommon['table_primary_key_camel'] = SimpleDataObjectConverter::snakeCaseToCamelCase($column);
            }
        }

        if(empty($replaceCommon['table_primary_key'])) {
                throw new \Magento\Framework\Exception\LocalizedException(
                    __('Cannot found primary key on table \'%1\'', $mastertable)
                );
        }


        $baseDirTpl = str_replace($this->_directoryRead->getAbsolutePath(), '', $this->_componentRegistrar->getPath(ComponentRegistrar::MODULE, 'ADM_DevBuilder')) .
            DIRECTORY_SEPARATOR .'Tpl';

        $dirTpl = $baseDirTpl . DIRECTORY_SEPARATOR .'Table';

        $classFull= [];
        foreach ($this->_directoryRead->readRecursively($dirTpl) as $path) {
            $itemName = basename($path);
            if ($this->_directoryRead->isFile($path)) {
                $tplContent = $this->_directoryRead->readFile($path);

                $tplContent = $this->getSearchReplaceLoop($tplContent, $replaceCol);

                $tplContent = $this->getSearchReplaceLoopType($tplContent, $replaceCol);

                $tplContent = $this->getSearchReplaceContent($tplContent, $replaceCommon);

                $tplDestPath = $this->getSearchReplaceFilePath(str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . str_replace($dirTpl, '', $path), $replaceCommon);

                $classFull[] = '-- ' . $tplDestPath;
                if($print) {
                    $classFull[] = $tplContent;
                } else {
                    $this->_directoryWrite->writeFile($tplDestPath, $tplContent, $writeMode);
                }

            }
        }

        return $classFull;
    }

    protected function getSearchReplaceLoop($search, $replaceCol)
    {
        $replacedSearch = $search;
        if(preg_match_all('/\{:LOOP_COLS([\S+\n\r\s]+?)LOOP_COLS\}/', $search, $match)) {
            foreach ($match[1] as $matchKey=>$searchTerm) {
                $replaceAllCols = [];
                foreach ($replaceCol as $replace) {
                    $replaceAllCols[] = $this->getSearchReplaceContent($searchTerm, $replace);
                }
                $replacedSearch = str_replace($match[0][$matchKey], implode($replaceAllCols), $replacedSearch);
            }
        }
        return $replacedSearch;

    }

    protected function getSearchReplaceLoopType($search, $replaceCol)
    {
        $replacedSearch = $search;
        if(preg_match_all('/\{:LOOP_COLS:(\w+):(\w+)([\S+\n\r\s]+?)LOOP_COLS:TYPE\}/', $search, $match)) {
            foreach ($match[3] as $matchKey=>$searchTerm) {
                $replaceAllCols = [];
                foreach ($replaceCol as $replace) {
                    if(isset($replace[$match[1][$matchKey]]) and $replace[$match[1][$matchKey]]==$match[2][$matchKey]) {
                        $replaceAllCols[] = $this->getSearchReplaceContent($searchTerm, $replace);
                    }
                }
                $replacedSearch = str_replace($match[0][$matchKey], implode($replaceAllCols), $replacedSearch);
            }
        }
        return $replacedSearch;

    }


    protected function getSearchReplaceFilePath($search, $replace)
    {
        return $this->getSearchReplace($search, $replace,'/__([a-zA-Z]\w+?[a-zA-Z])__/');
    }

    protected function getSearchReplaceContent($search, $replace)
    {
        return $this->getSearchReplace($search, $replace,'/\{:(\w+)\}/');
    }

    protected function getSearchReplace($search, $replace, $pattern)
    {
        $replacedSearch = $search;
        if(preg_match_all($pattern, $search, $match)) {
            foreach ($match[1] as $matchKey=>$searchTerm) {
                if(isset($replace[$searchTerm])) {
                    $replacedSearch = str_replace($match[0][$matchKey], $replace[$searchTerm], $replacedSearch);
                }
            }
        }

        return $replacedSearch;
    }


    protected function getMagentoType($type) {

        $mageType = ['smallint'=>'int',
        'int'=>'int',
        'varchar'=>'string',
        'text'=>'string',
        'decimal'=>'decimal',
        'timestamp'=>'string',
        'date'=>'string',
        ];

        return $mageType[$type];
    }


    protected function getColumnType($type) {

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

    protected function getColumnLength($row) {

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

    protected function getColumnConstraints($row) {
        $mapDefault = [];
        $mapDefault['CURRENT_TIMESTAMP'] = '\Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT';

        $constraints = [];
        if(!empty($row['IDENTITY'])) {
            $constraints[] = "'identity' => true";
        }
        if($this->getColumnIsPrimary($row)) {
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

    protected function getColumnIsRequired($row) {
        return empty($row['NULLABLE']) ? 'true' : 'false';
    }


    protected function getColumnIsPrimary($row) {
        return (!empty($row['PRIMARY']));
    }
}
