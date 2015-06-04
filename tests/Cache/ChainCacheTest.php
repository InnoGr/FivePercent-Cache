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
 * Testing Chain caching system
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
class ChainCacheTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \FivePercent\Component\Cache\CacheInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $cache1;

    /**
     * @var \FivePercent\Component\Cache\CacheInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $cache2;

    /**
     * @var ChainCache
     */
    private $cache;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        $this->cache1 = $this->getMockForAbstractClass('FivePercent\Component\Cache\CacheInterface');
        $this->cache2 = $this->getMockForAbstractClass('FivePercent\Component\Cache\CacheInterface');

        $this->cache = new ChainCache([$this->cache1, $this->cache2]);
    }

    /**
     * Test get from cache, and entry exists in first storage
     */
    public function testGetFromStorageAndExistsInFirstStorage()
    {
        $this->cache1->expects($this->once())->method('get')
            ->with('foo')->willReturn('bar');

        $this->cache2->expects($this->never())->method('get');

        $data = $this->cache->get('foo');

        $this->assertEquals('bar', $data);
    }

    /**
     * Test get from cache, and entry exists in second storage
     */
    public function testGetFromStorageAndExistsInSecondStorage()
    {
        $this->cache1->expects($this->once())->method('get')
            ->with('foo')->willReturn(null);

        $this->cache2->expects($this->once())->method('get')
            ->with('foo')->willReturn('bar');

        $data = $this->cache->get('foo');

        $this->assertEquals('bar', $data);
    }

    /**
     * Test get from storage, and entry not exists in storage
     */
    public function testGetFromStorageAndNotExists()
    {
        $this->cache1->expects($this->once())->method('get')
            ->with('foo')->willReturn(null);

        $this->cache2->expects($this->once())->method('get')
            ->with('foo')->willReturn(null);

        $data = $this->cache->get('foo');

        $this->assertNull($data);
    }

    /**
     * Test check exists in cache, and entry exists in first storage
     */
    public function testHasInStorageAndExistsInFirstStorage()
    {
        $this->cache1->expects($this->once())->method('has')
            ->with('bar')->willReturn(true);

        $this->cache2->expects($this->never())->method('has');

        $data = $this->cache->has('bar');

        $this->assertTrue($data);
    }

    /**
     * Test check exists in cache, and entry exists in second storage
     */
    public function testHasInStorageAndExistsInSecondStorage()
    {
        $this->cache1->expects($this->once())->method('has')
            ->with('bar')->willReturn(false);

        $this->cache2->expects($this->once())->method('has')
            ->with('bar')->willReturn(true);

        $data = $this->cache->has('bar');

        $this->assertTrue($data);
    }

    /**
     * Test check exists in cache, and entry not exists in storage
     */
    public function testHasInStorageAndNotExists()
    {
        $this->cache1->expects($this->once())->method('has')
            ->with('bar')->willReturn(false);

        $this->cache2->expects($this->once())->method('has')
            ->with('bar')->willReturn(false);

        $data = $this->cache->has('bar');

        $this->assertFalse($data);
    }
}
