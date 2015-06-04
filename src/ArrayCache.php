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
 * Simple array cache
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
class ArrayCache implements CacheInterface
{
    /**
     * @var array
     */
    private $storage = array();

    /**
     * {@inheritDoc}
     */
    public function get($key)
    {
        if (!isset($this->storage[$key])) {
            return null;
        }

        $entry = $this->storage[$key];

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

    /**
     * Has data exists in storage by key
     *
     * @param string $key
     *
     * @return bool
     */
    public function has($key)
    {
        return null !== $this->get($key);
    }

    /**
     * Set data to cache storage
     *
     * @param string $key
     * @param mixed  $data
     * @param int    $ttl
     *
     * @return bool
     */
    public function set($key, $data, $ttl = null)
    {
        if ($ttl) {
            $now = new \DateTime('now', new \DateTimeZone('UTC'));
            $expire = (int) $now->format('U') + $ttl;
        } else {
            $expire = 0;
        }

        $entry = array(
            'expire' => $expire,
            'value' => $data
        );

        $this->storage[$key] = $entry;

        return true;
    }

    /**
     * Remove data from storage
     *
     * @param string $key
     *
     * @return bool
     */
    public function remove($key)
    {
        unset ($this->storage[$key]);

        return true;
    }

    /**
     * Cleanup storage
     *
     * @return bool
     */
    public function cleanup()
    {
        $this->storage = array();

        return true;
    }
}
