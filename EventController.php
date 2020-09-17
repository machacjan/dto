<?php

namespace App\Esperio\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Esperio\CoreBundle\Entity\EventUser;
use App\Form\Type\EventUserType;
use App\Esperio\CoreBundle\Dto\EventUserDto;
use App\Esperio\CoreBundle\Service\DataTransferer\EventUserDataTransferer;

class EventController extends AbstractController
{

    public function editEventReportAction(
        EventReport $eventReport,
        Request $request, 
        EventReportDto $eventReportDto,
        EventReportDataTransferer $dataTransferer
    ) {
        
        $form = $this->createForm(
            EventReportType::class, 
            $dataTransferer->fromEntity($eventReport, $eventReportDto), 
            array(
                'page' => 'edit',
                'event' => $eventReport->getEvent(),
            ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $eventReport = $dataTransferer->fromRequest($form->getData(), $eventReport->getId());
        }
    }
}
