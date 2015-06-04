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
 * Array cache testing
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
class ArrayCacheTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ArrayCache
     */
    private $cache;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        $this->cache = new ArrayCache();
    }

    /**
     * Base testing
     */
    public function testBase()
    {
        $this->cache->set('foo', 'bar');
        $this->assertEquals('bar', $this->cache->get('foo'));
        $this->assertTrue($this->cache->has('foo'));
        $this->cache->remove('foo');
        $this->assertFalse($this->cache->has('foo'));
    }
}
