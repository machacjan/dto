<?php

namespace App\Esperio\CoreBundle\Dto;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

class EventReportDto
{

    //
    // Other content omitted
    //

    /**
     * @var Collection|EventUser[]
     */
    public $usersAttended;

    public function __construct()
    {
        $this->usersAttended = new ArrayCollection();
    }
}