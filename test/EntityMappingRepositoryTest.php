<?php
/**
 * This file is part of Cartograph
 *
 * For license information, please view the LICENSE file that was distributed with this source code.
 * Written by Peter Askey <peter_g_askey@live.co.uk>, 21/01/2020
 */

namespace FrankHouweling\Cartograph\test;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use FrankHouweling\Cartograph\EntityMappingRepository;
use FrankHouweling\Cartograph\Mapping\MappingInterface;
use FrankHouweling\Cartograph\test\TestClasses\Bar;
use FrankHouweling\Cartograph\test\TestClasses\BarProxy;
use FrankHouweling\Cartograph\test\TestClasses\Foo;
use FrankHouweling\Cartograph\test\TestClasses\FooProxy;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class EntityMappingRepositoryTest extends TestCase
{
    /** @var EntityManagerInterface|MockObject */
    private $entityManager;

    /** @var EntityMappingRepository */
    private $entityMappingRepository;

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManager::class);

        $this->entityMappingRepository = new EntityMappingRepository($this->entityManager);
    }

    /**
     * Tests that adding mapping using a combination of reflection classes and real classes results in the
     * same mapping.
     */
    public function testAddMapping(): void
    {
        $mappingClass = $this->createMock(MappingInterface::class);

        $this->entityMappingRepository->addMapping(
            FooProxy::class,
            BarProxy::class,
            get_class($mappingClass)
        );

        // Retrieve the mapping using the proxy classes and the expected real classes.
        $proxyMapping = $this->entityMappingRepository->getMapping(FooProxy::class, BarProxy::class);
        $realClassMapping = $this->entityMappingRepository->getMapping(Foo::class, Bar::class);

        // Both should point to the same mappingclass.
        $this->assertEquals($proxyMapping, $realClassMapping);
        $this->assertInstanceOf(MappingInterface::class, $proxyMapping);
    }
}