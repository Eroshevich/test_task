<?php

namespace Oqq\DoctrineFactory;

use Doctrine\Common\Cache\ApcuCache;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Cache\Cache;
use Doctrine\Common\Cache\RedisCache;
use Interop\Container\ContainerInterface;

/**
 * @author Eric Braun <eb@oqq.be>
 */
final class DoctrineCacheFactory
{
    /**
     * @param ContainerInterface $container
     *
     * @return Cache
     */
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->has('config') ? $container->get('config') : [];

        if (isset($config['debug']) && true === $config['debug']) {
            return new ArrayCache();
        }

        if ($container->has(RedisCache::class)) {
            return $container->get(RedisCache::class);
        }

        return new ApcuCache();
    }
}
