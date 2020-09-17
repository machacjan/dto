<?php

namespace App\Esperio\CoreBundle\Service\DataTransferer;

use App\Esperio\CoreBundle\Service\DataTransferer\AbstractDataTransferer;
use App\Esperio\CoreBundle\Entity\EventReport;
use App\Esperio\CoreBundle\Dto\EventReportDto;
use Doctrine\Common\Collections\Collection;

class EventReportDataTransferer extends AbstractDataTransferer
{

    /**
     * @param Collection|array $usersAttended
     * 
     * @return EventReport
     */
    public function transferData(
        $usersAttended
    ): EventReport
    {
        $report = $this->em->getRepository(EventReport::class)->findOneBy(array('id' => $this->id));

        $this->persistAndFlush($report);

        return $report;
    }

    public function fromRequest(
        EventReportDto $request
    ): EventReport
    {

        return $this->transferData(
            $request->usersAttended
        );
    }
}