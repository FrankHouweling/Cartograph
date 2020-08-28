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
     * Retrieves the mapping set for a transformation of $from to $to. And uses it to map the $to object.
     *
     * @param object $from
     * @param object|string $to
     * @return object
     * @throws \InvalidArgumentException if no valid MappingObject is found.
     */
    public function map(object $from, $to): object
    {
        if (is_string($to)) {
            $to = $this->getObject($to);
        }
        $mappingClass = $this->mappingRepository->getMapping(get_class($from), get_class($to));
        $mappingObject = $this->getMapping($mappingClass);
        return $mappingObject->map($from, $to, $this);
    }

    /**
     * @param string $mappingClass
     * @return MappingInterface
     */
    private function getMapping(string $mappingClass): MappingInterface
    {
        $mappingClass = (new $mappingClass());
        if ($this->container !== null && $this->container->has($mappingClass)) {
            $mappingClass = $this->container->get($mappingClass);
        }

        if (($mappingClass instanceof MappingInterface) === false) {
            throw new \LogicException(
                sprintf('Mapping class %s does not implement MappingInterface', $mappingClass)
            );
        }
        return (new $mappingClass());
    }

    /**
     * @param string $className
     * @return object
     * @throws \InvalidArgumentException
     */
    private function getObject(string $className): object
    {
        if (!class_exists($className)) {
            throw new \InvalidArgumentException("Invalid class `{$className}`. Check that the classname is spelled " .
                ' correctly, and the class is included or the autoloader is configured correctly.');
        }
        return new $className();
    }
}
