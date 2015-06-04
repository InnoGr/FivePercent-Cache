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
 * All caches should be implemented of this interface.
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
interface CacheInterface
{
    /**
     * Fetch data from storage
     *
     * @param string $key
     *
     * @return mixed
     */
    public function get($key);

    /**
     * Has data exists in storage by key
     *
     * @param string $key
     *
     * @return bool
     */
    public function has($key);

    /**
     * Set data to cache storage
     *
     * @param string $key
     * @param mixed  $data
     * @param int    $ttl
     *
     * @return bool
     */
    public function set($key, $data, $ttl = null);

    /**
     * Remove data from storage
     *
     * @param string $key
     *
     * @return bool
     */
    public function remove($key);

    /**
     * Cleanup storage
     *
     * @return bool
     */
    public function cleanup();
}
