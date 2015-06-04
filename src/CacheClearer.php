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

use Symfony\Component\HttpKernel\CacheClearer\CacheClearerInterface;

/**
 * Clearer cache for  Symfony2
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
class CacheClearer implements CacheClearerInterface
{
    /**
     * @var CacheInterface
     */
    private $cache;

    /**
     * Construct
     *
     * @param CacheInterface $cache
     */
    public function __construct(CacheInterface $cache)
    {
        $this->cache = $cache;
    }

    /**
     * {@inheritDoc}
     */
    public function clear($cacheDir)
    {
        $this->cache->cleanup();
    }
}
