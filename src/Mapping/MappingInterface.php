<?php
/**
 * This file is part of Cartograph
 *
 * For license information, please view the LICENSE file that was distributed with this source code.
 * Written by Frank Houweling <houweling.frank@gmail.com>, 8/22/2017
 */

namespace FrankHouweling\Cartograph\Mapping;

/**
 * Interface MappingInterface
 * @package FrankHouweling\Cartograph\Mapping
 */
interface MappingInterface
{
    /**
     * @param object $from
     * @param object $to
     * @return object
     */
    public function map(object $from, object $to): object;
}