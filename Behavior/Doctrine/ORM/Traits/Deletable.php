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
     */
    public function setDeletedAt(\DateTime $deletedAt = null)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isDeleted()
    {
        if (null !== $this->deletedAt) {
            return $this->deletedAt <= (new \DateTime());
        }

        return false;
    }

    public function delete()
    {
        $this->deletedAt = new \DateTime();
    }

    public function restore()
    {
        $this->deletedAt = null;
    }
}