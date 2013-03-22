<?php

namespace Flub\BigBangBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Nelmio\Alice\Fixtures;
use Symfony\Component\Finder\Finder;

/**
 * @author Florian Vilpoix
 * @author Florian Lonqueu-Brochard
 * @author KnpRadBundle team
 */
class AliceLoadFixturesCommand extends DoctrineORMCommand
{
    protected function configure()
    {
        $this
            ->setName('alice:fixtures:load')
            ->setDescription('Load alice fixtures in your project')
            ->addArgument('dir', InputArgument::REQUIRED, 'Select which fixtures directory you want to load (different from --env in which you will load them).')
            ->addOption('drop-schema', null, InputOption::VALUE_NONE)
            ->addOption('append', null, InputOption::VALUE_NONE)
            ->addOption('truncate-schema', null, InputOption::VALUE_NONE)
            ->addOption('bundles', 'b', InputOption::VALUE_OPTIONAL, 'Bundles where search the fixtures files (can be the full bundle name or a pattern)');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();

        if (!$input->getOption('append')
            && !$input->getOption('drop-schema')
            && !$input->getOption('truncate-schema')) {
            throw new \InvalidArgumentException('You have to choose a mode between "drop-schema", "truncate-schema" and "append"');
        }

        if ($input->getOption('drop-schema')) {
            $this->generateSchema();
        } elseif ($input->getOption('truncate-schema')) {
            $this->emptyDatabase();
        }

        $pattern = $input->getOption('bundles');

        foreach ($this->getKernel()->getBundles() as $bundle) {

            if ($pattern && !$this->matchPattern($bundle->getName(), $pattern)) {
                continue;
            }

            $files = $this->getAliceFiles($bundle->getPath(), $input->getArgument('dir'));

            if (($nbFiles = count($files)) === 0) {
               continue;
            }

            $output->writeln(
                sprintf("<info>[OK]</info> %s (%d files)", $bundle->getName(), $nbFiles)
            );

            foreach ($files as $file) {
                Fixtures::load($file, $em, $this->getAliceOptions());
            }
        }
    }

    protected function getAliceFiles($bundlePath, $dirName)
    {
        $paths = array();

        $fixturesDir = $bundlePath.DIRECTORY_SEPARATOR
                       .'Resources'.DIRECTORY_SEPARATOR
                       .'fixtures'.DIRECTORY_SEPARATOR
                       .$dirName;

        if (is_dir($fixturesDir)) {
            $paths[] = $fixturesDir;
        }

        if (0 === count($paths)) {
            return array();
        }

        return Finder::create()
            ->files()
            ->name('*.yml')
            ->depth(0)
            ->sortByName()
            ->in($paths)
        ;
    }

    protected function matchPattern($bundleName, $pattern)
    {
        return preg_match('#'.$pattern.'#', $bundleName) === 1;
    }

    protected function getAliceOptions()
    {
        return array('providers' => array($this));
    }
}
