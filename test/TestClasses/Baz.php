<?php
/**
 * This file is part of Cartograph
 *
 * For license information, please view the LICENSE file that was distributed with this source code.
 * Written by Frank Houweling <houweling.frank@gmail.com>, 21/01/2020
 */

namespace FrankHouweling\Cartograph\test\TestClasses;

/**
 * Class Baz
 * @package FrankHouweling\Cartograph\test\TestClasses
 */
final class Baz
{
    public $name;

    public function __construct()
    {
        $this->name = 'Baz';
    }
}