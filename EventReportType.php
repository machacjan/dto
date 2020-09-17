<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Esperio\CoreBundle\Dto\EventReportDto;
use App\Esperio\CoreBundle\Entity\EventUser;
use App\Form\Type\Components\EventUserType;
use Doctrine\ORM\EntityRepository;

class EventReportType extends AbstractType
{

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'translation_domain' => 'esperio_core',
            'allow_extra_fields' => true,
            'data_class' => EventReportDto::class,
            'label' => 'form.label.event_report',
            'page' => 'edit',
            'event' => null,
            'users_confirmed' => array(),
            'guests_confirmed' => array(),
        ));
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $page = $options['page'];
        $event = $options['event'];
        $usersConfirmed = $options['users_confirmed'];
        $guestsConfirmed = $options['guests_confirmed'];

        if ('create' == $page) {
            $builder
                ->add('usersAttended', EntityType::class, array(
                    'label' => 'form.label.users_attended',
                    'class' => EventUser::class,
                    'choice_label' => function($eventUser) {
                        return $eventUser->getUser()->getFullDisplayName();
                    },
                    'query_builder' => function (EntityRepository $er) use ($event) {
                        return $er->createQueryBuilder('u')
                            ->andWhere('u.event = :eventId')
                            ->setParameter('eventId', $event->getId());
                    },
                    'data' => $usersConfirmed,
                    'multiple' => true,
                    'row_attr' => array(
                        'class' => 'select has-multiple',
                    ),
                    'attr' => array(
                        'class' => 'js-choice',
                    ),
                    'required' => false,
                ));
        } else {
            $builder
                ->add('usersAttended', EntityType::class, array(
                    'label' => 'form.label.users_attended',
                    'class' => EventUser::class,
                    'choice_label' => function($eventUser) {
                        return $eventUser->getUser()->getFullDisplayName();
                    },
                    'query_builder' => function (EntityRepository $er) use ($event) {
                        return $er->createQueryBuilder('u')
                            ->andWhere('u.event = :eventId')
                            ->setParameter('eventId', $event->getId());
                    },
                    'multiple' => true,
                    'row_attr' => array(
                        'class' => 'select has-multiple',
                    ),
                    'attr' => array(
                        'class' => 'js-choice',
                    ),
                    'required' => false,
                ));
        }
    }
}