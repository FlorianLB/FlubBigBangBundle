<?php

namespace Flub\BigBangBundle\Controller;

use Knp\RadBundle\Controller\Controller as KnpController;

class ResourceOrientedController extends KnpController
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

        return $this->getEntityManager()->getRepository($this->baseEntity);
    }
}
