.. title:: Cache system

============
Cache system
============

With this package you can cache any data in any storage.

Installation
------------

Add **FivePercent/Cache** in your composer.json:

.. code-block:: json

    {
        "require": {
            "fivepercent/cache": "~1.0"
        }
    }


Now tell composer to download the library by running the command:


.. code-block:: bash

    $ php composer.phar update fivepercent/cache


Basic usage
-----------

Available storage:

#. **ArrayCache**
    Cache data in internal array. Will be destroyed after ended script.

#. **RedisCache**
    Cache data in Redis storage. Store data in HASH type.

#. **ChainCache**

#. **NullCache**

Examples:

.. code-block:: php

    use FivePercent\Component\Cache\ArrayCache;

    $cache = new ArrayCache();

    if (!$cache->has('my_key')) {
        $cache->set('my_key', 'My Value');
    }

    print $cache->get('my_key'); // Printing "My Value"


Symfony2
--------

If you use Symfony2 Framework, you can use **CacheClearer** for clear cache.

Symfony2 ExpressionLanguage
---------------------------

If you use ExpressionLanguage (Symfony Component), you can use **ParserCache** for store ExpressionLanguage expression.
