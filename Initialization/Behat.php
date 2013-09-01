<?php

namespace Flub\BigBangBundle\Initialization;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Console\Helper\DialogHelper;
use Symfony\Component\Filesystem\Filesystem;

use Composer\Json\JsonFile;
use Composer\Json\JsonManipulator;

class Behat implements InitializatorInterface
{
    const BEHAT_ROOT_DIR = '@FlubBigBangBundle/Resources/init/behat';

    protected $input;

    protected $output;

    protected $kernel;

    protected $dialog;

    protected static $packages = array(
        "behat/behat"                  => "2.4.*",
        "behat/symfony2-extension"     => "*",
        "behat/mink-extension"         => "*",
        "behat/mink-browserkit-driver" => "*",
    );

    public function __construct(
        InputInterface $input,
        OutputInterface $output,
        KernelInterface $kernel,
        DialogHelper $dialog)
    {
        $this->input  = $input;
        $this->output = $output;
        $this->kernel = $kernel;
        $this->dialog = $dialog;
    }

    public function execute()
    {
        $this->copyFiles();
        $this->editComposer();
    }

    protected function copyFiles()
    {
        $rootDir = $this->kernel->getRootDir().'/..';

        if (!file_exists($rootDir.'/behat.yml')) {
            $behatFile = $this->kernel->locateResource(static::BEHAT_ROOT_DIR.'/behat.yml');

            if (copy($behatFile, $rootDir.'/behat.yml')) {
                $this->output->writeln('<info>[OK]</info> "behat.yml" added');
            }
        }

        if (!file_exists($rootDir.'/features')) {
            $filesystemUtils = new Filesystem();
            $featuresDirName = static::BEHAT_ROOT_DIR.'/features';
            $featuresDir = $this->kernel->locateResource($featuresDirName);

            $filesystemUtils->mirror($featuresDir, $rootDir.'/features');
            $this->output->writeln('<info>[OK]</info> "features" directory added');
        }
    }

    protected function editComposer()
    {
        $auto     = $this->input->getOption('auto-update');
        $composer = class_exists('\Composer\Json\JsonFile');

        if (!$auto && $composer && $this->input->isInteractive()) {
            $auto = $this->dialog->askConfirmation(
                $this->output,
                '<info>Confirm automatic update of your <comment>composer.json</comment></info> [<comment>yes</comment>]?',
                true
            );
        }

        if ($auto && $composer) {
            return $this->autoAddPackage();
        }

        $this->output->writeln('<comment>[Action required]</comment> Please add the following lines in your composer.json : ');

        $this->output->writeln(<<<'COMPOSER'
    "require-dev": {
        "behat/behat": "2.4.*",
        "behat/symfony2-extension": "*",
        "behat/mink-extension": "*",
        "behat/mink-browserkit-driver": "*"
    },
COMPOSER
);
        $this->output->writeln(<<<'COMPOSER'
    "autoload": {
        "psr-0": {
            "": "src/",
            "Context": "features/"
        }
    },
COMPOSER
);
    }

    protected function autoAddPackage()
    {
        $file = $this->kernel->getRootDir().'/../composer.json';

        if (!file_exists($file)) {
            $this->output->writeln('<error>'.$file.' does not exists.</error>');

            return false;
        }
        if (!is_readable($file)) {
            $this->output->writeln('<error>'.$file.' is not readable.</error>');

            return false;
        }
        if (!is_writable($file)) {
            $this->output->writeln('<error>'.$file.' is not writable.</error>');

            return false;
        }

        $json = new JsonFile($file);
        $contents = file_get_contents($json->getPath());
        $manipulator = new JsonManipulator($contents);

        foreach (static::$packages as $package => $constraint) {
            if (!$manipulator->addLink('require-dev', $package, $constraint)) {
                return false;
            }
        }
        $manipulator->addSubNode('psr-0', 'Context', 'features/');

        file_put_contents($json->getPath(), $manipulator->getContents());
        $this->output->writeln('<info>[OK]</info> "composer.json" updated');

        return true;
    }
}