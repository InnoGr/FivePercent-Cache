<?php

/**
 * This file is part of the Cache package
 *
 * (c) InnovationGroup
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FivePercent\Component\Cache\ExpressionLanguage;

use FivePercent\Component\Cache\CacheInterface;
use Symfony\Component\ExpressionLanguage\ParsedExpression;
use Symfony\Component\ExpressionLanguage\ParserCache\ParserCacheInterface;

/**
 * Cache system for Symfony2 ExpressionLanguage
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
class ParserCache implements ParserCacheInterface
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
    public function save($key, ParsedExpression $expression)
    {
        $this->cache->set($key, $expression);
    }

    /**
     * {@inheritDoc}
     */
    public function fetch($key)
    {
        return $this->cache->get($key);
    }
}
