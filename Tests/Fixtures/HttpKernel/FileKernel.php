<?php

namespace Flub\BigBangBundle\Tests\Fixtures\HttpKernel;

use Flub\BigBangBundle\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Config\Loader\LoaderInterface;
use Flub\BigBangBundle\Initialization\Ant as AntInit;
use Flub\BigBangBundle\Initialization\Behat as BehatInit;

class FileKernel extends BaseKernel
{
    public function getRootDir()
    {
        return sys_get_temp_dir() . '/bigbangbundle-workspace/app';
    }

    public function registerBundles()
    {
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
    }

    public function locateResource($name, $dir = null, $first = true)
    {
        switch ($name) {
            case AntInit::ANT_ROOT_DIR . '/build.xml' :
                return __DIR__ . '/../../../Resources/init/ant/build.xml';
                break;
            case AntInit::ANT_ROOT_DIR . '/build' :
                return __DIR__ . '/../../../Resources/init/ant/build';
                break;
            case BehatInit::BEHAT_ROOT_DIR . '/behat.yml' :
                return __DIR__ . '/../../../Resources/init/behat/behat.yml';
                break;
            case BehatInit::BEHAT_ROOT_DIR . '/features' :
                return __DIR__ . '/../../../Resources/init/behat/features';
                break;
            default :
                return parent::locateResource($name, $dir, $first);
                break;
        }
    }
}