<?php

namespace Flub\BigBangBundle\Tests\Fixtures\Entity;

use Doctrine\ORM\Mapping as ORM;
use Flub\BigBangBundle\Behavior\Doctrine\ORM\Traits;

class Deletable
{
    use Traits\Deletable;

    /**
     * @ORM\Column(name="name", type="string", length=255)
     */
    public $foo;
}