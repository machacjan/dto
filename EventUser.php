<?php

namespace App\Esperio\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

class EventUser
{

    //
    // Other content omitted
    //
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Esperio\CoreBundle\Entity\EventReport", inversedBy="usersAttended", cascade={"persist"})
     * 
     * @var EventReport|null
     */
    private $eventReport;

    /**
     * @return EventReport|null
     */
    public function getEventReport(): ?EventReport
    {
        return $this->eventReport;
    }

    /**
     * @param EventReport|null
     * 
     * @return self
     */
    public function setEventReport(?EventReport $eventReport): self
    {
        $this->eventReport = $eventReport;

        return $this;
    }
}
