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

use Doctrine\Common\Cache\Cache;

/**
 * Adapter for use cache system with Doctrine libraries
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
class DoctrineCache implements Cache
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
    public function fetch($id)
    {
        return $this->cache->get($id) ?: false;
    }

    /**
     * {@inheritDoc}
     */
    public function contains($id)
    {
        return $this->cache->has($id);
    }

    /**
     * {@inheritDoc}
     */
    public function save($id, $data, $lifeTime = 0)
    {
        return $this->cache->set($id, $data, $lifeTime);
    }

    /**
     * {@inheritDoc}
     */
    public function delete($id)
    {
        return $this->cache->remove($id);
    }

    /**
     * {@inheritDoc}
     */
    public function getStats()
    {
        // Not supports
        return null;
    }
}
