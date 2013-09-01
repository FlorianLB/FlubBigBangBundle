<?php

namespace Flub\BigBangBundle\Tests\Initialization;

use Symfony\Component\Filesystem\Filesystem;

class TestBase extends \PHPUnit_Framework_TestCase
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

    public function tearDown()
    {
        $fs = new Filesystem();
        $fs->remove($this->getTestDir());
    }

}