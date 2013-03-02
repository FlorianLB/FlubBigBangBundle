<?php

namespace Flub\BigBangBundle\HttpKernel;

use Symfony\Component\HttpKernel\Kernel as BaseKernel;

/**
 * This class change directory structure of your cache and log directories.
 * app/cache/{env} is now var/cache/{env}
 * app/logs is now var/logs
 */
abstract class Kernel extends BaseKernel
{
    /**
     * Gets the var directory.
     *
     * @return string The var directory
     */
    public function getVarDir()
    {
        return $this->rootDir.'/../var';
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheDir()
    {
        return $this->getVarDir().'/cache/'.$this->environment;
    }

    /**
     * {@inheritdoc}
     */
    public function getLogDir()
    {
        return $this->getVarDir().'/logs';
    }
}
