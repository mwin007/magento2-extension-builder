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
        $mastertable = $questionHelper->ask($input, $output, $question);

        $question = new Question('Enter the name of the module table (will be created by the module, default: '.$mastertable.'): ', $mastertable);
        $table = $questionHelper->ask($input, $output, $question);

        $question = new Question('Enter the main classname in lower case with underscore (default: '.strtolower($table).'): ', strtolower($table));
        $classname = $questionHelper->ask($input, $output, $question);

        $question = new Question('Enter the namespace of the module. (default: YourCompany\YourModule): ', 'YourCompany\YourModule');
        $namespace = $questionHelper->ask($input, $output, $question);

        $defaultRoutename = $this->_helper->getDefaultRoutename($namespace);
        $question = new Question('Enter the routename of the module. (default: '.$defaultRoutename.'): ', $defaultRoutename);
        $routename = $questionHelper->ask($input, $output, $question);

        $classFull = $this->_helper->getTemplate($mastertable, $table, $classname, $namespace, $routename);

        if (!empty($classFull)) {
            $output->writeln(self::LINE_SEP);
            $output->writeln('Building module files');
            $output->writeln($classFull);
            $output->writeln(self::LINE_SEP);
            $output->writeln('In order to test your new module you have to:');
            $output->writeln('1. copy module folder from var/tmp to app/code');
            $output->writeln('2. run "bin/magento setup:upgrade" from the Magento root directory');
            $output->writeln('3. check install visiting the url /' . $routename);
            return;
        }
    }

    protected function executeTest(InputInterface $input, OutputInterface $output)
    {
        $questionHelper = new QuestionHelper();

        $question = new Question('Enter the name of the master table (already created in database): ', 'ashsmith_blog_post_copy');
        $mastertable = $questionHelper->ask($input, $output, $question);

        $question = new Question('Enter the name of the module table (will be created by the module, default: '.$mastertable.'): ', 'ashsmith_blog_post');
        $table = $questionHelper->ask($input, $output, $question);

        $question = new Question('Enter the main classname in lower case with underscore (default: '.strtolower($table).'): ', 'post');
        $classname = $questionHelper->ask($input, $output, $question);

        $question = new Question('Enter the namespace of the module. (default: YourCompany\YourModule): ', 'Ashsmith\Blog');
        $namespace = $questionHelper->ask($input, $output, $question);

        $defaultRoutename = $this->_helper->getDefaultRoutename($namespace);
        $question = new Question('Enter the routename of the module. (default: '.$defaultRoutename.'): ', 'blog');
        $routename = $questionHelper->ask($input, $output, $question);

        $classFull = $this->_helper->getTemplate($mastertable, $table, $classname, $namespace, $routename);

        if (!empty($classFull)) {
            $output->writeln(self::LINE_SEP);
            $output->writeln('Building module files');
            $output->writeln($classFull);
            $output->writeln(self::LINE_SEP);
            $output->writeln('In order to test your new module you have to:');
            $output->writeln('1. copy module folder from var/tmp to app/code');
            $output->writeln('2. run "bin/magento setup:upgrade" from the Magento root directory');
            $output->writeln('3. check install visiting the url /' . $routename);
            return;
        }
    }

}
