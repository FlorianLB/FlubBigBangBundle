<?php

namespace Flub\BigBangBundle\Initialization;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Filesystem\Filesystem;

class Ant implements InitializatorInterface
{
    const ANT_ROOT_DIR = '@FlubBigBangBundle/Resources/init/ant';

    protected $input;

    protected $output;

    protected $kernel;

    public function __construct(
        InputInterface $input,
        OutputInterface $output,
        KernelInterface $kernel)
    {
        $this->input  = $input;
        $this->output = $output;
        $this->kernel = $kernel;
    }

    public function execute()
    {
        $this->copyFiles();
    }

    protected function copyFiles()
    {
        $rootDir = $this->kernel->getRootDir().'/..';

        if (!file_exists($rootDir.'/build.xml')) {
            $buildFile = $this->kernel->locateResource(static::ANT_ROOT_DIR.'/build.xml');

            if (copy($buildFile, $rootDir.'/build.xml')) {
                $this->output->writeln('<info>[OK]</info> "build.xml" added');
            }
        }

        if (!file_exists($rootDir.'/build')) {
            $filesystemUtils = new Filesystem();
            $buildDirName = static::ANT_ROOT_DIR.'/build';
            $buildDir = $this->kernel->locateResource($buildDirName);

            $filesystemUtils->mirror($buildDir, $rootDir.'/build');
            $this->output->writeln('<info>[OK]</info> "build" directory added');
        }
    }
}