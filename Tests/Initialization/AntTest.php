<?php

namespace Flub\BigBangBundle\Tests\Initialization;

use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\StreamOutput;
use Flub\BigBangBundle\Tests\Fixtures\HttpKernel\FileKernel;
use Flub\BigBangBundle\Initialization\Ant;

class AntTest extends TestBase
{
    public function testExecute()
    {
        $kernel = new FileKernel('pony', false);
        $input  = new ArrayInput(array());
        $output = new StreamOutput(fopen('php://memory', 'w', false));

        $ant = new Ant($input, $output, $kernel);
        $ant->execute();

        $this->assertTrue(file_exists($this->getTestDir(). '/build.xml'));
        $this->assertTrue(is_dir($this->getTestDir(). '/build'));
        $this->assertTrue(is_dir($this->getTestDir(). '/build/config'));
        $this->assertTrue(file_exists($this->getTestDir(). '/build/config/phpcs.xml'));
        $this->assertTrue(file_exists($this->getTestDir(). '/build/config/phpdox.xml'));
        $this->assertTrue(file_exists($this->getTestDir(). '/build/config/phpmd.xml'));
    }
}