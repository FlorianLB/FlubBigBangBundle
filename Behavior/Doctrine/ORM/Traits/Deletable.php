<?php

namespace Flub\BigBangBundle\Behavior\Doctrine\ORM\Traits;

use Doctrine\ORM\Mapping as ORM;

trait Deletable
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @return \DateTime
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * @param \DateTime $deletedAt
     *
     * @return Deletable
     */
    public function setDeletedAt(\DateTime $deletedAt = null)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    public function isDeleted()
    {
        return $this->getDeletedAt() !== null;
    }
}