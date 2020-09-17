<?php
/**
 * This file is a part of the Esperio Project.
 *
 * Copyright (c) Jan Macháč <jan.machac4@gmail.com>
 *
 * All rights reserved.
 */

namespace App\Esperio\CoreBundle\Service\DataTransferer;

use Doctrine\ORM\EntityManagerInterface;
use App\Esperio\CoreBundle\Service\Settings;
use Symfony\Component\Security\Core\Security;
use Doctrine\DBAL\Logging\DebugStack;

/**
 * Class AbstractDataTransferer
 * 
 * @author Jan Macháč <jan.machac4@gmail.com>
 */
class AbstractDataTransferer
{

    /**
     * @var EntityManagerInterface
     */
    public $em;

    /**
     * @var Settings
     */
    private $settings;

    /**
     * @var int|null
     */
    public $id;

    /**
     * @var User|null
     */
    public $currentUser;

    /**
     * @var DebugStack
     */
    public $logger;

    /**
     * @param EntityManagerInterface $em
     * @param Settings $settings
     */
    public function __construct(
        EntityManagerInterface $em, 
        Settings $settings,
        Security $security
    )
    {
        $this->em = $em;
        $this->settings = $settings;
        $this->currentUser = $security->getUser();

        if ('dev' === $_SERVER['APP_ENV']) {
            $this->logger = new DebugStack();
            $this->em->getConnection()->getConfiguration()->setSQLLogger($this->logger);
        }
    }

    /**
     * @param object $entity
     * 
     * @return self
     */
    public function persistAndFlush($entity): self
    {
        $this->em->persist($entity);
        $this->em->flush();
        //dd($this->logger);

        return $this;
    }

    /**
     * @param object $entity
     * 
     * @return self
     */
    public function persist($entity): self
    {
        $this->em->persist($entity);

        return $this;
    }

    /**
     * @param object $entity
     * @param object $dto
     * 
     * @return object
     */
    public function fromEntity($entity, $dto)
    {
        $entityMethods = get_class_methods($entity);
        $dtoProperties = get_object_vars($dto);

        if (!empty($entityMethods) && !empty($dtoProperties)) {
            foreach ($dtoProperties as $name => $property) {
                $value = null;
                if (method_exists($entity, 'get' . ucfirst($name))) {
                    $method = 'get' . ucfirst($name);
                    $value = $entity->$method();
                } else if (method_exists($entity, 'is' . ucfirst($name))) {
                    $method = 'is' . ucfirst($name);
                    $value = $entity->$method();
                } else if (method_exists($entity, 'has' . ucfirst($name))) {
                    $method = 'has' . ucfirst($name);
                    $value = $entity->$method();
                }
                $dto->$name = $value;
            }
        }

        return $dto;
    }

    public function getAppId()
    {
        return $this->settings->getSettings()->getAppId();
    }
}