<?php
/**
 * This file is part of Cartograph
 *
 * For license information, please view the LICENSE file that was distributed with this source code.
 * Written by Peter Askey <peter_g_askey@live.co.uk>, 21/01/2020
 */

namespace FrankHouweling\Cartograph\test;

use FrankHouweling\Cartograph\Mapping\MappingInterface;
use FrankHouweling\Cartograph\MappingRepository;
use FrankHouweling\Cartograph\TestClasses\Bar;
use FrankHouweling\Cartograph\TestClasses\Baz;
use FrankHouweling\Cartograph\TestClasses\Foo;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class MappingRepositoryTest extends TestCase
{

    /** @var MappingRepository */
    private $mappingRepository;

    /** @var MappingInterface|MockObject */
    private $mapping;

    protected function setUp(): void
    {
        $this->mappingRepository = new MappingRepository();
        $this->mapping = $this->createMock(MappingInterface::class);
    }

    /**
     * Control test for adding mapping to the repository, and then retrieving it.
     * Happy path.
     */
    public function testAddMapping(): void
    {
        $this->mappingRepository->addMapping(
            Foo::class,
            Bar::class,
            get_class($this->mapping)
        );

        $mappingClass = $this->mappingRepository->getMapping(Foo::class, Bar::class);
        $this->assertEquals(get_class($this->mapping), $mappingClass);
    }

    /**
     * Asserts that if the $from class does not exist, an InvalidArgumentException is thrown.
     */
    public function testAddMappingForNonexistantFromClass(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->mappingRepository->addMapping(
            'nonexistantClass',
            Bar::class,
            get_class($this->mapping)
        );
    }

    /**
     * Asserts that if the $to class does not exist, an InvalidArgumentException is thrown.
     */
    public function testAddMappingForNonexistantToClass(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->mappingRepository->addMapping(
            Foo::class,
            'nonexistantClass',
            get_class($this->mapping)
        );
    }

    /**
     * Asserts that if the $mappingClass does not exist, an InvalidArgumentException is thrown.
     */
    public function testAddMappingForNonexistantMappingClass(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->mappingRepository->addMapping(
            Foo::class,
            Bar::class,
            'nonexistantClass'
        );
    }

    /**
     * Asserts that if the Source class is known, but the target is not, an InvalidArgumentException is thrown.
     */
    public function testGetMappingInvalidTarget(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->mappingRepository->getMapping(Foo::class, Baz::class);
    }

    /**
     * Asserts that if the Source class is not known, an InvalidArgumentException is thrown.
     */
    public function testGetMappingInvalidSource(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->mappingRepository->getMapping(Bar::class, Baz::class);
    }
}