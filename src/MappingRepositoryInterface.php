<?php
/*
 * Copyright (C) Senet Eindhoven B.V. - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Frank Houweling <fhouweling@senet.nl>, 13-8-2018
 */

namespace FrankHouweling\Cartograph;

/**
 * Interface MappingRepositoryInterface
 * @package cartograph\src
 */
interface MappingRepositoryInterface
{
    /**
     * Register a new mapping between two classes.
     * @param string $fromClass
     * @param string $toClass
     * @param string $mappingClass
     * @return void
     */
    public function addMapping(string $fromClass, string $toClass, string $mappingClass): void;

    /**
     * Retrieve the registered mapping for two given classes.
     * @param $fromClass
     * @param $toClass
     * @return string
     */
    public function getMapping(string $fromClass, string $toClass): string;
}