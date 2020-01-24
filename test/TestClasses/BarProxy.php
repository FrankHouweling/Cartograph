<?php
/**
 * This file is part of Cartograph
 *
 * For license information, please view the LICENSE file that was distributed with this source code.
 * Written by Frank Houweling <houweling.frank@gmail.com>, 21/01/2020
 */

namespace FrankHouweling\Cartograph\test\TestClasses;

use Closure;
use Doctrine\Common\Proxy\Proxy;

/**
 * Class BarProxy
 * @package FrankHouweling\Cartograph\test\TestClasses
 */
final class BarProxy extends Bar implements Proxy
{
    public $name;

    /**
     * @inheritDoc
     */
    public function __setInitialized($initialized)
    {
    }

    /**
     * @inheritDoc
     */
    public function __setInitializer(Closure $initializer = null)
    {
    }

    /**
     * @inheritDoc
     */
    public function __getInitializer()
    {
    }

    /**
     * @inheritDoc
     */
    public function __setCloner(Closure $cloner = null)
    {
    }

    /**
     * @inheritDoc
     */
    public function __getCloner()
    {
    }

    /**
     * @inheritDoc
     */
    public function __getLazyProperties()
    {
    }

    /**
     * @inheritDoc
     */
    public function __load()
    {
    }

    /**
     * @inheritDoc
     */
    public function __isInitialized()
    {
    }
}