<?php

/*
 * This file is a part of dflydev/psr0-resource-locator.
 *
 * (c) Dragonfly Development Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dflydev\Psr0ResourceLocator;

/**
 * PSR-0 Resource Locator Interface
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
interface Psr0ResourceLocatorInterface
{
    /**
     * Find all directories from namespaceish string.
     *
     * @param string $namespaceish
     *
     * @return array
     */
    public function findDirectories($namespaceish);

    /**
     * Find first directory from namespaceish string.
     *
     * @param string $namespaceish
     *
     * @return string
     */
    public function findFirstDirectory($namespaceish);

    /**
     * Find one directory from namespaceish string.
     *
     * @param string $namespaceish
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    public function findOneDirectory($namespaceish);
}
