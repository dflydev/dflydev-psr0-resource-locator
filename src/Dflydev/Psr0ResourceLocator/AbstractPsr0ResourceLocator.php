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
 * Abstract PSR-0 Resource Locator
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
abstract class AbstractPsr0ResourceLocator implements Psr0ResourceLocatorInterface
{
    private $cache = array();
    private $map;

    /**
     * Load map
     *
     * Implementations use this to load the namespace => directory mapping.
     *
     * @return array
     */
    abstract protected function loadMap();

    /**
     * {@inheritdoc}
     */
    public function findDirectories($namespaceish)
    {
        if (array_key_exists($namespaceish, $this->cache)) {
            return $this->cache[$namespaceish];
        }

        return $this->cache[$namespaceish] = $this->searchMap($namespaceish);
    }

    /**
     * {@inheritdoc}
     */
    public function findFirstDirectory($namespaceish)
    {
        $directories = $this->findDirectories($namespaceish);

        if (0 === count($directories)) {
            return null;
        }

        return $directories[0];
    }

    /**
     * {@inheritdoc}
     */
    public function findOneDirectory($namespaceish)
    {
        $directories = $this->findDirectories($namespaceish);

        if (0 === count($directories)) {
            return null;
        }

        if (count($directories) > 1) {
            throw new \RuntimeException("Expected exactly one directory, found ".count($directories)." instead. (".implode(', ', $directories).")");
        }

        return $directories[0];
    }

    private function assertNormalizedMap()
    {
        if (null !== $this->map) {
            return $this->map;
        }

        $normalizedMap = array();

        foreach ($this->loadMap() as $namespace => $dirs) {
            if ('\\' == $namespace[0]) {
                $namespace = substr($namespace, 1);
            }

            if (false !== $pos = strrpos($namespace, '\\')) {
                if (strlen($namespace) === $pos+1) {
                    $namespace = substr($namespace, 0, $pos);
                }
            }

            $normalizedMap[$namespace] = $dirs;
        }

        $this->map = $normalizedMap;
    }

    private function searchMap($namespaceish)
    {
        $this->assertNormalizedMap();

        $searchPath = str_replace('\\', DIRECTORY_SEPARATOR, $namespaceish);

        $directories = array();
        foreach ($this->map as $namespace => $dirs) {
            if (0 === strpos($namespaceish, $namespace)) {
                foreach ($dirs as $dir) {
                    if (is_dir($directory = $dir.'/'.$searchPath)) {
                        $directories[] = $directory;
                    }
                }
            }
        }

        return array_unique($directories);
    }
}
