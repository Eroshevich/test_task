<?php

namespace Oqq\DoctrineFactory;

use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Cache\Cache;
use Doctrine\Common\Cache\RedisCache;
use Interop\Container\ContainerInterface;

/**
 * @author Eric Braun <eb@oqq.be>
 */
final class DoctrineCacheFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var ContainerInterface */
    private $container;

    /** @var DoctrineCacheFactory */
    private $factory;

    public function setUp()
    {
        $this->container = $this->prophesize(ContainerInterface::class);
        $this->factory = new DoctrineCacheFactory();

        $this->container->has('config')->willReturn(false);
        $this->container->has(RedisCache::class)->willReturn(false);
    }

    public function testCache()
    {
        $this->callFactory();
    }

    public function testDebug()
    {
        $this->container->has('config')->willReturn(true);
        $this->container->get('config')->willReturn(['debug' => true]);

        $doctrineCache = $this->callFactory();
        static::assertInstanceOf(ArrayCache::class, $doctrineCache);
    }

    public function testRedis()
    {
        $redisCache = $this->prophesize(RedisCache::class);

        $this->container->has(RedisCache::class)->willReturn(true);
        $this->container->get(RedisCache::class)->willReturn($redisCache->reveal());

        $doctrineCache = $this->callFactory();
        static::assertInstanceOf(RedisCache::class, $doctrineCache);
    }

    /**
     * @return Cache
     */
    private function callFactory()
    {
        $callable = $this->factory;
        $doctrineCache = $callable($this->container->reveal());

        static::assertInstanceOf(Cache::class, $doctrineCache);

        return $doctrineCache;
    }
}
