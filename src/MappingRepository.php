<?php
/**
 * This file is part of Cartograph
 *
 * For license information, please view the LICENSE file that was distributed with this source code.
 * Written by Frank Houweling <houweling.frank@gmail.com>, 8/22/2017
 */

namespace FrankHouweling\Cartograph;

/**
 * Class MappingRepository
 * @package FrankHouweling\Cartograph
 */
class MappingRepository
{
    private $mappingCollection[];

    /**
     * @param string $fromClass
     * @param string $toClass
     * @param string $mapperClass
     * @throws \InvalidArgumentException
     */
    public function addMapping(string $fromClass, string $toClass, string $mappingClass)
    {
        foreach([$fromClass, $toClass, $mappingClass] as $class)
        {
            if(!class_exists($class))
            {
                throw new \InvalidArgumentException("Given classname {$class} is not a valid class, "
                    . ' or could not be loaded. Include the file, or configure the autoloader.');
            }
        }

        // Initiate empty array when necessary.
        if(!isset($this->mappingCollection[$fromClass]))
        {
            $this->mappingCollection[$fromClass] = [];
        }

        $this->mappingCollection[$fromClass][$toClass] = $mappingClass;
    }

    /**
     * @param $fromClass
     * @param $toClass
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public function getMapping($fromClass, $toClass)
    {
        if(isset($this->mappingCollection[$fromClass][$toClass]))
        {
            return $this->mappingCollection[$fromClass][$toClass];
        }

        if(isset($this->mappingCollection[$fromClass]))
        {
            throw new \InvalidArgumentException("No mapping is set for target class `{$toClass}` and source class `{$fromClass}`."
                . 'The following target classes are available for the source:' . implode(', ', $this->mappingCollection[$fromClass]));
        }
        throw new \InvalidArgumentException("No mappings are defined for source class `{$fromClass}`.");
    }
}