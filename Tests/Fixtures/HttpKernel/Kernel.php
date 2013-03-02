<?php

namespace Flub\BigBangBundle\Tests\Fixtures\HttpKernel;

use Flub\BigBangBundle\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class Kernel extends BaseKernel
{
    public function getRootDir()
    {
        return '/tmp/unicorn/app';
    }

    public function registerBundles()
    {
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
    }
}