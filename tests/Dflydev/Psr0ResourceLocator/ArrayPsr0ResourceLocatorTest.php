<?php

namespace Dflydev\Psr0ResourceLocator;

/**
 * ArrayPsr0ResourceLocator test
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class ArrayPsr0ResourceLocatorTest extends \PHPUnit_Framework_TestCase
{
    protected function getBasicFixtureMapping()
    {
        return array(
            'Namespace\Alpha' => array(__DIR__.'/Fixtures', __DIR__.'/Fixtures/Alternate'),
            'Namespace\Alpha\Resources' => array(__DIR__.'/Fixtures'),
            'Namespace\Beta' => array(__DIR__.'/Fixtures', '/path/to/stuff/beta'),
            'Namespace\Beta\Resources' => array(__DIR__.'/Fixtures'),
            'Namespace\Delta' => array('/path/to/stuff/delta'),
            '\Namespace\Gamma\A' => array(),
            'Namespace\Gamma\B\\' => array(),
            '\Namespace\Gamma\C\\' => array(),
        );
    }

    /**
     * Empty tests
     */
    public function testEmpty()
    {
        $resourceLocator = new ArrayPsr0ResourceLocator;

        $directories = $resourceLocator->findDirectories('Foo\Bar\Baz');
        $this->assertCount(0, $directories);

        $directory = $resourceLocator->findFirstDirectory('Foo\Bar\Baz');
        $this->assertNull($directory);

        $directory = $resourceLocator->findOneDirectory('Foo\Bar\Baz');
        $this->assertNull($directory);

        // For code coverage, ensure that assertNormalizedMap() will return
        // existing map on new searches.
        $directories = $resourceLocator->findDirectories('Foo\Bar\Bat');
        $this->assertCount(0, $directories);
    }

    /**
     * Simple tests (single directory found)
     */
    public function testSimpleSingleDirectory()
    {
        $resourceLocator = new ArrayPsr0ResourceLocator($this->getBasicFixtureMapping());

        $directories = $resourceLocator->findDirectories('Namespace\Beta\Resources\mappings');
        $this->assertCount(1, $directories);
        $this->assertEquals(__DIR__.'/Fixtures/Namespace/Beta/Resources/mappings', $directories[0]);

        $directory = $resourceLocator->findFirstDirectory('Namespace\Beta\Resources\mappings');
        $this->assertEquals(__DIR__.'/Fixtures/Namespace/Beta/Resources/mappings', $directory);

        $directory = $resourceLocator->findOneDirectory('Namespace\Beta\Resources\mappings');
        $this->assertEquals(__DIR__.'/Fixtures/Namespace/Beta/Resources/mappings', $directory);

        // Going to do these same tests again (ugly, I know...
        $directories = $resourceLocator->findDirectories('Namespace\Beta\Resources\mappings');
        $this->assertCount(1, $directories);
        $this->assertEquals(__DIR__.'/Fixtures/Namespace/Beta/Resources/mappings', $directories[0]);

        $directory = $resourceLocator->findFirstDirectory('Namespace\Beta\Resources\mappings');
        $this->assertEquals(__DIR__.'/Fixtures/Namespace/Beta/Resources/mappings', $directory);

        $directory = $resourceLocator->findOneDirectory('Namespace\Beta\Resources\mappings');
        $this->assertEquals(__DIR__.'/Fixtures/Namespace/Beta/Resources/mappings', $directory);
    }

    /**
     * Simple tests (multiple directories found)
     */
    public function testSimpleMultipleDirectories()
    {
        $resourceLocator = new ArrayPsr0ResourceLocator($this->getBasicFixtureMapping());

        $directories = $resourceLocator->findDirectories('Namespace\Alpha\Resources\mappings');
        $this->assertCount(2, $directories);
        $this->assertEquals(__DIR__.'/Fixtures/Namespace/Alpha/Resources/mappings', $directories[0]);
        $this->assertEquals(__DIR__.'/Fixtures/Alternate/Namespace/Alpha/Resources/mappings', $directories[1]);

        $directory = $resourceLocator->findFirstDirectory('Namespace\Alpha\Resources\mappings');
        $this->assertEquals(__DIR__.'/Fixtures/Namespace/Alpha/Resources/mappings', $directory);

        try {
            $directory = $resourceLocator->findOneDirectory('Namespace\Alpha\Resources\mappings');

            $this->fail('Expected exception due to finding multiple directories.');
        } catch (\RuntimeException $e) {
            $this->assertContains('Expected exactly one directory, found 2 instead.', $e->getMessage());
        }
    }
}
