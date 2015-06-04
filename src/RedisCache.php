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
 * Redis cache storage
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
class RedisCache implements CacheInterface
{
    /**
     * @var \Redis
     */
    private $redis;

    /**
     * @var string
     */
    private $cacheKey;

    /**
     * Construct
     *
     * @param \Redis $redis
     * @param string $cacheKey
     */
    public function __construct(\Redis $redis, $cacheKey = 'cache')
    {
        $this->redis = $redis;
        $this->cacheKey = $cacheKey;
    }

    /**
     * {@inheritDoc}
     */
    public function set($key, $value, $ttl = 0)
    {
        if ($ttl) {
            $now = new \DateTime('now', new \DateTimeZone('UTC'));
            $expire = (int) $now->format('U') + $ttl;
        } else {
            $expire = 0;
        }

        $entry = array(
            'expire' => $expire,
            'value' => $value
        );

        $this->redis->hSet($this->cacheKey, $key, serialize($entry));
    }

    /**
     * Get entry from cache storage
     *
     * @param string $key
     *
     * @return mixed
     */
    public function get($key)
    {
        $entry = $this->redis->hGet($this->cacheKey, $key);

        if ($entry) {
            $entry = unserialize($entry);

            if ($entry['expire']) {
                // Check expires
                $now = new \DateTime('now', new \DateTimeZone('UTC'));
                if ((int) $now->format('U') > $entry['expire']) {
                    $this->remove($key);

                    return null;
                }
            }

            return $entry['value'];
        }

        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function has($key)
    {
        if (!$this->redis->hExists($this->cacheKey, $key)) {
            return false;
        }

        return null === $this->get($key) ? false : true;
    }

    /**
     * {@inheritDoc}
     */
    public function remove($key)
    {
        $this->redis->hDel($this->cacheKey, $key);

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function cleanup()
    {
        $this->redis->del($this->cacheKey);

        return true;
    }
}
