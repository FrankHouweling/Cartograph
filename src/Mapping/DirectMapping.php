<?php
/**
 * This file is part of Cartograph
 *
 * For license information, please view the LICENSE file that was distributed with this source code.
 * Written by Frank Houweling <houweling.frank@gmail.com>, 8/22/2017
 */

namespace FrankHouweling\Cartograph\Mapping;

/**
 * Class DirectMapping
 * @package FrankHouweling\Cartograph\Mapping
 */
class DirectMapping implements MappingInterface
{
    /**
     * @param object $from
     * @param object $to
     * @return object
     */
    public function map(object $from, object $to): object
    {
        $this->mapAttributeValues($this->getAttributeValues($from), $to);
        return $to;
    }

    /**
     * @param object $from
     * @return array
     */
    private function getAttributeValues(object $from)
    {
        $reflect = new \ReflectionClass($from);
        $attributes   = $reflect->getProperties();

        $attributeValues = [];
        foreach($attributes as $attribute)
        {
            if($attribute->isStatic())
            {
                continue;
            }

            $attributeValues[$attribute->getName()] = $attribute->getValue()
            ];
        }

        return $attributeValues;
    }

    /**
     * @param array $attributeValues
     * @param object $to
     */
    private function mapAttributeValues(array $attributeValues, object $to)
    {
        $reflect = new \ReflectionClass($to);
        foreach($attributeValues as $name => $value)
        {
            try{
                $property = $reflect->getProperty($name);
                if($property->isPublic())
                {
                    $to->$name = $value;
                }
                $setterMethod = 'set' . ucfirst($name);
                if($reflect->getMethod($setterMethod))
                {
                    $to->$setterMethod($value);
                }
            }
            catch(\ReflectionException $e)
            {
                continue;
            }
        }
    }
}