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
 * Chain cache
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
class ChainCache implements CacheInterface
{
    /**
     * @var array
     */
    private $caches = array();

    /**
     * @var bool
     */
    private $sortedCaches = false;

    /**
     * @var int
     */
    private $defaultTtl;

    /**
     * Construct
     *
     * @param array|CacheInterface[] $caches
     * @param int                    $defaultTtl
     */
    public function __construct(array $caches = array(), $defaultTtl = 300)
    {
        $this->defaultTtl = $defaultTtl;

        $index = 0;
        foreach ($caches as $cache) {
            $this->addCache($cache, $index++);
        }
    }

    /**
     * Get default TTL
     *
     * @return int
     */
    public function getDefaultTtl()
    {
        return $this->defaultTtl;
    }

    /**
     * Add cache to storage
     *
     * @param CacheInterface $cache
     * @param int            $priority
     */
    public function addCache(CacheInterface $cache, $priority = 0)
    {
        $this->caches[spl_object_hash($cache)] = array(
            'cache' => $cache,
            'priority' => $priority
        );

        $this->sortedCaches = null;
    }

    /**
     * {@inheritDoc}
     */
    public function get($key)
    {
        /** @var CacheInterface[] $empties */
        $empties = array();

        $this->sortCaches();

        foreach ($this->caches as $entry) {
            /** @var CacheInterface $cache */
            $cache = $entry['cache'];
            $data = $cache->get($key);

            if (null !== $data) {
                foreach ($empties as $emptyCache) {
                    $emptyCache->set($key, $data, $this->defaultTtl);
                }

                return $data;
            }

            $empties[] = $cache;
        }

        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function has($key)
    {
        $this->sortCaches();

        foreach ($this->caches as $entry) {
            /** @var CacheInterface $cache */
            $cache = $entry['cache'];
            if (true === $cache->has($key)) {
                return true;
            }
        }

        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function set($key, $data, $ttl = null)
    {
        $this->sortCaches();

        foreach ($this->caches as $entry) {
            /** @var CacheInterface $cache */
            $cache = $entry['cache'];
            $cache->set($key, $data, $ttl);
        }

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function remove($key)
    {
        $this->sortCaches();

        foreach ($this->caches as $entry) {
            /** @var CacheInterface $cache */
            $cache = $entry['cache'];
            $cache->remove($key);
        }

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function cleanup()
    {
        $this->sortCaches();

        foreach ($this->caches as $entry) {
            /** @var CacheInterface $cache */
            $cache = $entry['cache'];
            $cache->cleanup();
        }

        return true;
    }

    /**
     * Sort caches
     */
    protected function sortCaches()
    {
        if (null !== $this->sortedCaches) {
            return;
        }

        $this->sortedCaches = true;

        uasort($this->caches, function ($a, $b) {
            if ($a['priority'] == $b['priority']) {
                return 0;
            }

            return $a['priority'] > $b['priority'] ? 1 : -1;
        });
    }
}
