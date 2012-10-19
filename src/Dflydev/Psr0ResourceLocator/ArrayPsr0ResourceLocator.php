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
 * Array PSR-0 Resource Locator
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class ArrayPsr0ResourceLocator extends AbstractPsr0ResourceLocator
{
    private $map = array();

    /**
     * Constructor
     *
     * @param array $map
     */
    public function __construct(array $map = array())
    {
        $this->map = $map;
    }

    /**
     * {@inheritdoc}
     */
    protected function loadMap()
    {
        return $this->map;
    }
}
