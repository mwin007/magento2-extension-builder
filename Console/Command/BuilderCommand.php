<?php

namespace ADM\DevBuilder\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Question\Question;


class BuilderCommand extends Command
{
    const INPUT_KEY_PRINT = 'print';

    const LINE_SEP = ' ------------';

    protected $_helper;

    /**
     * Constructor
     *
     */
    public function __construct(
            \ADM\DevBuilder\Helper\Data $builderHelper
    ) {
        $this->_helper = $builderHelper;

        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('dev:builder');
        $this->setDescription('Generate module files (php, phtml and xml)');

        $this->addOption(
                self::INPUT_KEY_PRINT,
                null,
                InputOption::VALUE_NONE,
                'Print code on screen (by default will create files in var/tmp/YourCompany/YourModule)'
        );

        parent::configure();
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $questionHelper = new QuestionHelper();

        $question = new Question('Enter the name of the master table (already created in database): ');
        $this->_helper->setInputParam('mastertable', $questionHelper->ask($input, $output, $question));

        $question = new Question('Enter the name of the module table (will be created by the module, default: '.$this->_helper->getInputParam('mastertable').'): ', $this->_helper->getInputParam('mastertable'));
        $this->_helper->setInputParam('table', $questionHelper->ask($input, $output, $question));

        $question = new Question('Enter the main classname in lower case with underscore (default: '.$this->_helper->getInputParam('table').'): ', $this->_helper->getInputParam('table'));
        $this->_helper->setInputParam('class_name', $questionHelper->ask($input, $output, $question));

        $question = new Question('Enter the namespace of the module. (default: '.$this->_helper->getInputParam('namespace', 'YourCompany\YourModule').'): ', $this->_helper->getInputParam('namespace', 'YourCompany\YourModule'));
        $this->_helper->setInputParam('namespace', $questionHelper->ask($input, $output, $question));

        $question = new Question('Enter the routename of the module. (default: '.$this->_helper->getInputParamFormat('namespace', 'lower_alpha').'): ', $this->_helper->getInputParamFormat('namespace', 'lower_alpha'));
        $this->_helper->setInputParam('route_name', $questionHelper->ask($input, $output, $question));

        $classFull = $this->_helper->getTemplate();

        return $this->displayOutput($output, $classFull);
    }

    protected function displayOutput(OutputInterface $output, $classFull)
    {
        if (!empty($classFull)) {
            $output->writeln(self::LINE_SEP);
            $output->writeln('Building module files');
            $output->writeln($classFull);
            $output->writeln(self::LINE_SEP);
            $output->writeln('In order to test your new module you have to:');
            $output->writeln('1. copy module folder from var/tmp to app/code');
            $output->writeln('2. run "bin/magento setup:upgrade" from the Magento root directory');
            $output->writeln('3. check install visiting the url /' . $this->_helper->getInputParam('route_name') . '/' . $this->_helper->getInputParamFormat('class_name', 'lower'));
            return;
        }
    }
}
