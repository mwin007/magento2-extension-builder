<?php

namespace ADM\DevBuilder\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;


class AbstractTplCommand extends Command
{
    const TABLE_NAME = 'table';

    const NAME_SPACE = 'namespace';

    protected $_resource;

    /**
     * Constructor
     *
     */
    public function __construct(
            \Magento\Framework\App\ResourceConnection $resourceConnection
    ) {
        $this->_resource = $resourceConnection;

        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->addArgument(
                self::TABLE_NAME,
                InputArgument::REQUIRED,
                'Name of the table already created in database'
        );

        $this->addArgument(
                self::NAME_SPACE,
                InputArgument::OPTIONAL,
                'Namespace of the module. You have to use double backslashes, ie: Company\\\\Module'
        );

        parent::configure();
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $table = $input->getArgument(self::TABLE_NAME);

        $namespace = $input->getArgument(self::NAME_SPACE);
        if(empty($namespace)) {
            $namespace='YOUR_NAMESPACE';
        }

        $describe = $this->_resource->getConnection()->describeTable($table);

        $classFull = $this->processTemplate($table, $describe, $namespace);

        if (!empty($classFull)) {
            $output->writeln($classFull);
            return;
        }
    }


    protected function getSearchReplace($search, $replace)
    {
        $replacedSearch = $search;
        if(preg_match_all('/\{:(\w+)\}/', $search, $match)) {
            foreach (array_unique($match[1]) as $searchTerm) {
                if(isset($replace[$searchTerm])) {
                    $replacedSearch = str_replace('{:'.$searchTerm.'}', $replace[$searchTerm], $replacedSearch);
                }
            }
        }

        return $replacedSearch;
    }

    protected function processTemplate($table, $describe, $namespace)
    {
        return 'You have to define a "processTemplate" method in your class!';
    }
}
