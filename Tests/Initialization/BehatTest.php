<?php

namespace Flub\BigBangBundle\Tests\Initialization;

use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Output\StreamOutput;
use Flub\BigBangBundle\Tests\Fixtures\HttpKernel\FileKernel;
use Flub\BigBangBundle\Initialization\Behat;
use Symfony\Component\Console\Helper\DialogHelper;

class BehatTest extends TestBase
{
    public function testExecute()
    {
        $kernel = new FileKernel('pony', false);
        $input  = new ArrayInput(
            array('--auto-update' => false),
            new InputDefinition(array(new InputOption('auto-update')))
        );
        $input->setInteractive(false);
        $output = new StreamOutput(fopen('php://memory', 'w', false));

        $behat = new Behat($input, $output, $kernel, new DialogHelper());
        $behat->execute();

        $this->assertTrue(file_exists($this->getTestDir(). '/behat.yml'));
        $this->assertTrue(is_dir($this->getTestDir(). '/features'));
    }
}
