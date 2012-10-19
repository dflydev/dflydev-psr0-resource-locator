PSR-0 Resource Locator
======================

Locate resources by namespaceish paths using [PSR-0][1] mappings.

Locating resources relative to a class within the same package can
be done by `__DIR__.'/../Resources`. The downside to this method is
that it only works if the target resources are in the same package.

This project aims to allow for locating resources from any namespace
whether the intended directory is in the same package or not.

The term *namespaceish* is used instead of namespace as it should be
understood that we are overloading the [PSR-0][1] conventions to find
*files* and not PHP code. In fact, we may often be looking for
directories under a namespace that are in fact not namespaces at all.


Requirements
------------

 * PHP 5.3+
 * A PSR-0 Resource Locator Implementation 
    * Composer — [dflydev/psr0-resource-locator-composer][2]

Installation
------------

This library can installed by [Composer][4].


Usage
-----

```php
<?php

use Dflydev\Psr0ResourceLocator\Composer\ComposerResourceLocator;

$resourceLocator = new ComposerResourceLocator;

// Search all PSR-0 namespaces registered by Composer
// to find the first directory found looking like:
// "/Vendor/Project/Resources/mappings"
$mappingDirectory = $resourceLocator->findFirstDirectory(
    'Vendor\Project\Resources\mappings'
);

// Search all PSR-0 namespaces registered by Composer
// to find all templates directories looking like:
// "/Vendor/Project/Resources/templates"
$templateDirs = $resourceLocator->findDirectories(
    'Vendor\Project\Resources\templates',
);

```

The use of `Resources` in these examples is not meant to imply that
only `/Resources/` paths can be found. Implementations should be
capable of finding any directory/directories as long as they follow
[PSR-0][1] naming guidelines *and the mapping was registered*.


Know Implementations
--------------------

### Composer — [dflydev/psr0-resource-locator-composer][2]

The Composer PSR-0 Resource Locator implementation leverages
[dflydev/composer-autoload][3] to locate the effective Composer autoloader
in use at runtime and accesses its namespace map.

For any project that uses Composer this is the implementation you are
looking for.


License
-------

MIT, see LICENSE.


Community
---------

If you have questions or want to help out, join us in the [#dflydev][5]
channel on irc.freenode.net.


Not Invented Here
-----------------

Based on the `classpath:` concept from [Spring Framework][6].


[1]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md
[2]: https://github.com/dflydev/dflydev-psr0-resource-locator-composer
[3]: https://github.com/dflydev/dflydev-composer-autoload
[4]: http://getcomposer.org/
[5]: irc://irc.freenode.net/#dflydev
[6]: http://www.springsource.org/spring-framework


