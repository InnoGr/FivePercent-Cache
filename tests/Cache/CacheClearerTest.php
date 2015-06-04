<?php

/**
 * This file is part of the Cache package
 *
 * (c) InnovationGroup
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FivePercent\Component\Cache;

/**
 * Testing cache clearer system
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
class CacheClearerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test correct call to Cache::clear on clearer
     */
    public function testClear()
    {
        $cacheInstance = $this->getMockForAbstractClass(
            'FivePercent\Component\Cache\CacheInterface'
        );

        $cacheInstance->expects($this->once())->method('cleanup');

        $cacheClearer = new CacheClearer($cacheInstance);
        $cacheClearer->clear(null);
    }
}
