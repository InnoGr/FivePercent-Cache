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
 * Null cache. Not store
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
class NullCache implements CacheInterface
{
    /**
     * {@inheritDoc}
     */
    public function get($key)
    {
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function has($key)
    {
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function set($key, $data, $ttl = null)
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function remove($key)
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function cleanup()
    {
        return true;
    }
}
