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
 * Class FooProxy
 * @package FrankHouweling\Cartograph\test\TestClasses
 */
class FooProxy extends Foo implements Proxy
{
    public $name;

    /**
     * @inheritDoc
     */
    public function __setInitialized($initialized)
    {
        // TODO: Implement __setInitialized() method.
    }

    /**
     * @inheritDoc
     */
    public function __setInitializer(Closure $initializer = null)
    {
        // TODO: Implement __setInitializer() method.
    }

    /**
     * @inheritDoc
     */
    public function __getInitializer()
    {
        // TODO: Implement __getInitializer() method.
    }

    /**
     * @inheritDoc
     */
    public function __setCloner(Closure $cloner = null)
    {
        // TODO: Implement __setCloner() method.
    }

    /**
     * @inheritDoc
     */
    public function __getCloner()
    {
        // TODO: Implement __getCloner() method.
    }

    /**
     * @inheritDoc
     */
    public function __getLazyProperties()
    {
        // TODO: Implement __getLazyProperties() method.
    }

    /**
     * @inheritDoc
     */
    public function __load()
    {
        // TODO: Implement __load() method.
    }

    /**
     * @inheritDoc
     */
    public function __isInitialized()
    {
        // TODO: Implement __isInitialized() method.
    }
}