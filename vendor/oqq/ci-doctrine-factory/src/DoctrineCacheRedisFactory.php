<?php

namespace Oqq\DoctrineFactory;

use Doctrine\Common\Cache\RedisCache;
use Interop\Container\ContainerInterface;

/**
 * @author Eric Braun <eb@oqq.be>
 */
final class DoctrineCacheRedisFactory
{
    /**
     * @param ContainerInterface $container
     *
     * @return RedisCache
     */
    public function __invoke(ContainerInterface $container)
    {
        if ($container->has(\Redis::class)) {
            $redis = $container->get(\Redis::class);
        } else {
            $redis = $this->getRedisConnection($this->getRedisConfig($container));
        }

        $cache = new RedisCache();
        $cache->setRedis($redis);

        return $cache;
    }

    /**
     * @param ContainerInterface $container
     *
     * @return array
     */
    private function getRedisConfig(ContainerInterface $container)
    {
        if (!$container->has('config')) {
            return [];
        }

        $config = $container->get('config');

        if (!isset($config['doctrine']['cache']['redis'])) {
            return [];
        }

        return $config['doctrine']['cache']['redis'];
    }

    /**
     * @param array $config
     *
     * @return \Redis
     */
    private function getRedisConnection(array $config)
    {
        $redis = new \Redis();
        $host = isset($config['host']) ? $config['host'] : 'localhost';

        if (isset($config['port'])) {
            $redis->connect($host, $config['port']);
        } else {
            $redis->connect($host);
        }

        return $redis;
    }
}
