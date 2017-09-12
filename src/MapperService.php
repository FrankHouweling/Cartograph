<?php
/**
 * This file is part of Cartograph
 *
 * For license information, please view the LICENSE file that was distributed with this source code.
 * Written by Frank Houweling <houweling.frank@gmail.com>, 8/22/2017
 */

namespace FrankHouweling\Cartograph;

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

    public function __construct(MappingRepository $mappingRepository)
    {
        $this->mappingRepository = $mappingRepository;
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
        $mapping = $this->mappingRepository->getMapping(get_class($from), get_class($to));
        return (new $mapping())->map($from, $to, $mapping);
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