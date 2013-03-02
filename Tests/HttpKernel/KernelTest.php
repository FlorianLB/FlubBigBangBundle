<?php

namespace Flub\BigBangBundle\Tests\HttpKernel;

use Flub\BigBangBundle\Tests\Fixtures\Entity\Deletable;
use Flub\BigBangBundle\Tests\Fixtures\HttpKernel\Kernel;

class KernelTest extends \PHPUnit_Framework_TestCase
{
    public function testDirs()
    {
        $kernel = new Kernel('pony', false);

        $this->assertEquals($kernel->getVarDir(), '/tmp/unicorn/app/../var');

        $this->assertEquals(
            $kernel->getLogDir(),
            '/tmp/unicorn/app/../var/logs'
        );

        $this->assertEquals(
            $kernel->getCacheDir(),
            '/tmp/unicorn/app/../var/cache/pony'
        );
    }
}