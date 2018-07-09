<?php
/**
 * This file is part of Cartograph
 *
 * For license information, please view the LICENSE file that was distributed with this source code.
 * Written by Frank Houweling <houweling.frank@gmail.com>, 8/22/2017
 */

namespace FrankHouweling\Cartograph;

use FrankHouweling\Cartograph\Mapping\MappingInterface;
use Psr\Container\ContainerInterface;

/**
 * Class MapperService
 * @package FrankHouweling\Cartograph
 */
class MapperService
{
    /**
     * @var MappingRepository
     */
    private $mappingRepository;

    /**
     * @var null|ContainerInterface
     */
    private $container;

    /**
     * MapperService constructor.
     * @param MappingRepository $mappingRepository
     * @param null|ContainerInterface $container
     */
    public function __construct(
        MappingRepository $mappingRepository,
        ?ContainerInterface $container = null
    )
    {
        $this->mappingRepository = $mappingRepository;
        $this->container = $container;
    }

    /**
     * @param object $from
     * @param object|string $to
     * @return object
     * @throws \InvalidArgumentException
     */
    public function map($from, $to)
    {
        if(is_string($to))
        {
            $to = $this->getObject($to);
        }
        $mappingClass = $this->mappingRepository->getMapping(get_class($from), get_class($to));
        $mappingObject = $this->getMapping($mappingClass);
        if(($mappingObject instanceof MappingInterface) === false)
        {
            throw new \LogicException(
                sprintf('Mapping class %s given as mapping %s -> %s does not implement MappingInterface'),
                $mapping,
                get_class($from),
                get_class($to)
            );
        }
        return $mappingObject->map($from, $to, $this);
    }

    /**
     * @param string $mappingClass
     * @return MappingInterface
     */
    private function getMapping(string $mappingClass): MappingInterface
    {
        if($this->container->has($mapping))
        {
            return $this->container->get($mapping);
        }
        return (new $mapping());
    }

    /**
     * @param string $className
     * @return object
     * @throws \InvalidArgumentException
     */
    private function getObject(string $className)
    {
        if(!class_exists($className))
        {
            throw new \InvalidArgumentException("Invalid class `{$className}`. Check that the classname is spelled " .
                ' correctly, and the class is included or the autoloader is configured correctly.');
        }
        return new $className();
    }
}