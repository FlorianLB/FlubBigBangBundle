<?php

namespace Flub\BigBangBundle\Tests\Behavior\Doctrine\ORM\Traits;

use Flub\BigBangBundle\Tests\Fixtures\Entity\Deletable;

class DeletableTest extends \PHPUnit_Framework_TestCase
{
    public function testIsDeleted()
    {
        $deletable = new Deletable();

        $deletable->setDeletedAt(new \DateTime('- 1 day'));
        $this->assertTrue($deletable->isDeleted());

        $deletable->setDeletedAt(new \DateTime('+ 1 day'));
        $this->assertFalse($deletable->isDeleted());
    }

    public function testDelete()
    {
        $deletable = new Deletable();

        $this->assertFalse($deletable->isDeleted());
        $deletable->delete();
        $this->assertTrue($deletable->isDeleted());
    }

    public function testRestore()
    {
        $deletable = new Deletable();
        $deletable->setDeletedAt(new \DateTime('- 1 day'));

        $this->assertTrue($deletable->isDeleted());
        $deletable->restore();
        $this->assertFalse($deletable->isDeleted());
    }
}