<?php

namespace App\Esperio\CoreBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Doctrine\ORM\Mapping as ORM;

class EventReport
{

    //
    // Other content omitted
    //

    /**
     * @ORM\OneToMany(targetEntity="App\Esperio\CoreBundle\Entity\EventUser", mappedBy="eventReport", cascade={"persist"})
     * 
     * @var Collection|EventUser[]
     */
    private $usersAttended;

    public function __construct()
    {
        $this->usersAttended = new ArrayCollection();
    }

    /**
     * @return Collection|EventUser[]
     */
    public function getUsersAttended(): Collection
    {
        return $this->usersAttended;
    }

    /**
     * @param EventUser $user
     * 
     * @return self
     */
    public function addUserAttended(EventUser $user): self
    {
        if (!$this->usersAttended->contains($user)) {
            $this->usersAttended[] = $user;
            $user->setEventReport($this);
        }

        return $this;
    }

    /**
     * @param EventUser $user
     * 
     * @return self
     */
    public function removeUserAttended(EventUser $user): self
    {
        if ($this->usersAttended->contains($user)) {
            $this->usersAttended->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getEventReport() === $this) {
                $user->setEventReport(null);
            }
        }

        return $this;
    }
}
