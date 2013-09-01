<?php

namespace Flub\BigBangBundle\Initialization;

use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\StreamOutput;
use Flub\BigBangBundle\Tests\Fixtures\HttpKernel\FileKernel;
use Flub\BigBangBundle\Initialization\Ant;
use Symfony\Component\Filesystem\Filesystem;

class AntTest extends \PHPUnit_Framework_TestCase
{

    protected function getTestDir()
    {
        return sys_get_temp_dir() . '/bigbangbundle-workspace';
    }

    public function setUp()
    {
        if (is_dir($this->getTestDir())) {
            $fs = new Filesystem();
            $fs->remove($this->getTestDir());
        }

        mkdir($this->getTestDir());
        mkdir($this->getTestDir() . '/app');
    }

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

    public function tearDown()
    {
        $fs = new Filesystem();
        $fs->remove($this->getTestDir());
    }

}