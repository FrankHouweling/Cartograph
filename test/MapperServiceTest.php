<?php
/**
 * This file is part of Cartograph
 *
 * For license information, please view the LICENSE file that was distributed with this source code.
 * Written by Peter Askey <peter_g_askey@live.co.uk>, 21/01/2020
 */

namespace FrankHouweling\Cartograph\test;

use FrankHouweling\Cartograph\MapperService;
use FrankHouweling\Cartograph\Mapping\MappingInterface;
use FrankHouweling\Cartograph\MappingRepositoryInterface;
use FrankHouweling\Cartograph\test\TestClasses\Bar;
use FrankHouweling\Cartograph\test\TestClasses\Baz;
use FrankHouweling\Cartograph\test\TestClasses\Foo;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

final class MapperServiceTest extends TestCase
{

    /** @var MappingRepositoryInterface|MockObject */
    private $mappingRepository;

    /** @var ContainerInterface|MockObject */
    private $container;

    /** @var MappingInterface|MockObject */
    private $mappingObject;

    /** @var MapperService */
    private $mapperServiceWithContainer;

    /** @var MapperService */
    private $mapperServiceWithoutContainer;

    protected function setUp(): void
    {
        $this->mappingRepository = $this->createMock(MappingRepositoryInterface::class);
        $this->container = $this->createMock(ContainerInterface::class);
        $this->mappingObject = $this->createMock(MappingInterface::class);

        $this->mapperServiceWithContainer = new MapperService(
            $this->mappingRepository,
            $this->container
        );

        $this->mapperServiceWithoutContainer = new MapperService($this->mappingRepository);
    }

    /**
     * Tests the happy path of 2 objects being passed to be mapped, using the container
     */
    public function testMapObjectToObject(): void
    {
        $foo = new Foo();
        $bar = new Bar();

        $this->mappingRepository->expects($this->once())
            ->method(' getMapping')
            ->with(get_class($foo), get_class($bar))
            ->willReturn(MappingInterface::class);

        $this->container->expects($this->once())
            ->method('has')
            ->with(MappingInterface::class)
            ->willReturn(true);

        $this->container->expects($this->once())
            ->method('get')
            ->with(MappingInterface::class)
            ->willReturn($this->mappingObject);

        $this->mappingObject->expects($this->once())
            ->method('map')
            ->with($foo, $bar, $this->mappingObject)
            ->willReturn($bar);

        $result = $this->mapperServiceWithContainer->map($foo, $bar);
        $this->assertInstanceOf(Bar::class, $result);
    }

    /**
     * Tests that if the service has no ContainerInterface, the mappingClass is instantiated to continue as normal.
     */
    public function getMappingWithoutContainer(): void
    {
        $foo = new Foo();
        $bar = new Bar();

        $this->mappingRepository->expects($this->once())
            ->method(' getMapping')
            ->with(get_class($foo), get_class($bar))
            ->willReturn(MappingInterface::class);

        $this->container->expects($this->once())
            ->method('has')
            ->with(MappingInterface::class)
            ->willReturn(true);

        $this->mappingObject->expects($this->once())
            ->method('map')
            ->with($foo, $bar, $this->mappingObject)
            ->willReturn($bar);

        $result = $this->mapperServiceWithoutContainer->map($foo, $bar);
        $this->assertInstanceOf(Bar::class, $result);
    }

    /**
     * Tests that if a className string is passed as the target parameter, the mapperservice creates a new instance
     * of that class and continues to function as expected.
     */
    public function testMapWithStringTarget(): void
    {
        $foo = new Foo();

        $this->mappingRepository->expects($this->once())
            ->method(' getMapping')
            ->with(get_class($foo), Bar::class)
            ->willReturn(MappingInterface::class);

        $this->container->expects($this->once())
            ->method('has')
            ->with(MappingInterface::class)
            ->willReturn(true);

        $this->container->expects($this->once())
            ->method('get')
            ->with(MappingInterface::class)
            ->willReturn($this->mappingObject);

        $this->mappingObject->expects($this->once())
            ->method('map');

        $result = $this->mapperServiceWithContainer->map($foo, Bar::class);
        $this->assertInstanceOf(Bar::class, $result);
    }

    /**
     * Asserts that if the string passed as a target class is not a class, an exception is raised.
     */
    public function testMapWithInvalidStringTarget(): void
    {
        $foo = new Foo();
        $this->expectException(\InvalidArgumentException::class);
        $this->mapperServiceWithContainer->map($foo, 'nonexistantClass');
    }

    /**
     * Tests that if the retrieved mapping is not an instance of MappingInterface, an exception is raised.
     */
    public function testMappingObjectIsNotMappingInterface(): void
    {
        $foo = new Foo();
        $bar = new Bar();

        $this->mappingRepository->expects($this->once())
            ->method(' getMapping')
            ->with(get_class($foo), get_class($bar))
            ->willReturn(Baz::class);

        $this->expectException(\LogicException::class);
        $this->mapperServiceWithContainer->map($foo, $bar);
    }
}