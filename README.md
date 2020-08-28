# Cartograph
This library is used to Map PHP object to other objects

## Installation
Install this library using composer
```bash
composer require frank-houweling/cartograph
```

## Getting Started
To use this library create an instance of the `MapperService`, using your preffered `MappingRepositoryInterface`
````php
<?php
use FrankHouweling\Cartograph\MapperService;
use FrankHouweling\Cartograph\Mapping\DirectMapping;
use FrankHouweling\Cartograph\MappingRepository;

$foo = new Foo();
$bar = new Bar();

// Initiate the MapperService
$mappingRepository = new MappingRepository();
$mapperService = new MapperService($mappingRepository);

// Register a mapping from Foo, to Bar using the DirectMapping
$mappingRepository->addMapping(Foo::class, Bar::class, DirectMapping::class);

// Map Foo -> Bar. Will fetch the previously registered Mapping
$mapperService->map($foo, $bar);
````

## Creating custom Mappings
 The `DirectMapping` uses reflection to map attributes 1:1. Should this not meet your requirements, you can create
 a custom mapping by implementing the `MappingInterface` and registering it to the `MappingRepository` as shown above. 