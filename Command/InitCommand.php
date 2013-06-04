<?php

namespace Flub\BigBangBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Flub\BigBangBundle\Initialization as Init;

class InitCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('bigbang:init')
            ->setDescription('Init your project')
            ->addOption('auto-update', null, InputOption::VALUE_NONE, false)
            ->addOption('behat', null, InputOption::VALUE_NONE)
            ->addOption('ant', null, InputOption::VALUE_NONE)
            ->addOption('jenkins', null, InputOption::VALUE_NONE, 'alias for --ant');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($input->getOption('behat')) {
            $behatInitializator = new Init\Behat(
                $input,
                $output,
                $this->getContainer()->get('kernel'),
                $this->getHelperSet()->get('dialog')
            );
            $behatInitializator->execute();
        }

        if ($input->getOption('ant') || $input->getOption('jenkins')) {
            $antInitializator = new Init\Ant(
                $input,
                $output,
                $this->getContainer()->get('kernel')
            );
            $antInitializator->execute();
        }
    }
}
