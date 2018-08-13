<?php
/*
 * Copyright (C) Senet Eindhoven B.V. - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Frank Houweling <fhouweling@senet.nl>, 13-8-2018
 */

namespace FrankHouweling\Cartograph;

use Doctrine\Common\Util\ClassUtils;
use Doctrine\ORM\EntityManager;

/**
 * Class EntityMappingRepository
 * @package FrankHouweling\Cartograph
 */
final class EntityMappingRepository extends MappingRepository
{
    /** @var EntityManager */
    private $entityManager;

    /**
     * EntityMappingRepository constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $fromClass
     * @param string $toClass
     * @param string $mappingClass
     */
    public function addMapping(string $fromClass, string $toClass, string $mappingClass)
    {
        parent::addMapping(
            $this->getRealClass($fromClass),
            $this->getRealClass($toClass),
            $this->getRealClass($mappingClass)
        );
    }

    /**
     * @param string $fromClass
     * @param string $toClass
     * @return string
     */
    public function getMapping(string $fromClass, string $toClass): string
    {
        $from = $this->getRealClass($fromClass);
        $to = $this->getRealClass($toClass);
        return parent::getMapping(
            $from,
            $to
        );
    }

    /**
     * @param string $className
     * @return string
     */
    private function getRealClass(string $className): string
    {
        if (in_array(\Doctrine\ORM\Proxy\Proxy::class, class_implements($className)) === false)
        {
            return $className;
        }
        return ClassUtils::getRealClass($className);
    }
}