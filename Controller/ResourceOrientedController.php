<?php

namespace Flub\BigBangBundle\Controller;

class ResourceOrientedController extends Controller
{
    /**
     * The base entity that this controller will manage
     */
    protected $baseEntity = '';

    protected function getRepository($entity = null)
    {
        if ($entity !== null) {
            return parent::getRepository($entity);
        }

        if (empty($this->baseEntity)) {
            throw new \Exception('You must define a baseEntity for a resource oriented controller');
        }

        return parent::getRepository($this->baseEntity);
    }
}
