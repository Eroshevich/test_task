<?php

namespace Oqq\DoctrineFactory;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Annotations\CachedReader;
use Doctrine\Common\Cache\Cache;
use Doctrine\Common\EventManager;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Mapping\UnderscoreNamingStrategy;
use Doctrine\ORM\ORMException;
use Gedmo\DoctrineExtensions;
use Gedmo\Mapping\MappedEventSubscriber;
use Interop\Container\ContainerInterface;
use Ramsey\Uuid\Doctrine\UuidType;

/**
 * @author Eric Braun <eb@oqq.be>
 */
final class DoctrineEntityManagerFactory
{
    /**
     * @param ContainerInterface $container
     *
     * @return EntityManagerInterface
     * @throws ORMException
     */
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->has('config') ? $container->get('config') : [];

        $proxyDir = isset($config['doctrine']['orm']['proxy_dir']) ?
            $config['doctrine']['orm']['proxy_dir'] : 'data/cache/EntityProxy';
        $proxyNamespace = isset($config['doctrine']['orm']['proxy_namespace']) ?
            $config['doctrine']['orm']['proxy_namespace'] : 'EntityProxy';
        $autoGenerateProxyClasses = isset($config['doctrine']['orm']['auto_generate_proxy_classes']) ?
            $config['doctrine']['orm']['auto_generate_proxy_classes'] : false;
        $underscoreNamingStrategy = isset($config['doctrine']['orm']['underscore_naming_strategy']) ?
            $config['doctrine']['orm']['underscore_naming_strategy'] : false;
        $entityPaths = isset($config['doctrine']['orm']['entity_paths']) ?
            $config['doctrine']['orm']['entity_paths'] : ['src'];

        // Doctrine ORM
        $doctrine = new Configuration();
        $doctrine->setProxyDir($proxyDir);
        $doctrine->setProxyNamespace($proxyNamespace);
        $doctrine->setAutoGenerateProxyClasses($autoGenerateProxyClasses);

        if ($underscoreNamingStrategy) {
            $doctrine->setNamingStrategy(new UnderscoreNamingStrategy());
        }

        // Cache
        $cache = $container->get(Cache::class);
        $doctrine->setQueryCacheImpl($cache);
        $doctrine->setResultCacheImpl($cache);
        $doctrine->setMetadataCacheImpl($cache);

        // ORM mapping by Annotation
        AnnotationRegistry::registerFile('vendor/doctrine/orm/lib/Doctrine/ORM/Mapping/Driver/DoctrineAnnotations.php');

        if (class_exists(DoctrineExtensions::class)) {
            DoctrineExtensions::registerAnnotations();
        }

        $cachedAnnotationReader = new CachedReader(new AnnotationReader(), $cache);
        $driver = new AnnotationDriver($cachedAnnotationReader, $entityPaths);

        $doctrine->setMetadataDriverImpl($driver);

        $eventManager = new EventManager();

        if (isset($config['doctrine']['orm']['event_subscribers'])) {
            foreach ($config['doctrine']['orm']['event_subscribers'] as $subscriber) {
                $subscriberInstance = $container->get($subscriber);

                if ($subscriberInstance instanceof MappedEventSubscriber) {
                    $subscriberInstance->setAnnotationReader($cachedAnnotationReader);
                }

                $eventManager->addEventSubscriber($subscriberInstance);
            }
        }

        $entityManager = EntityManager::create(
            $config['doctrine']['connection']['orm_default'],
            $doctrine,
            $eventManager
        );

        // Types
        Type::addType('uuid', UuidType::class);
        $entityManager->getConnection()->getDatabasePlatform()->registerDoctrineTypeMapping('uuid', 'uuid');

        if (isset($config['doctrine']['orm']['types'])) {
            foreach ($config['doctrine']['orm']['types'] as $type => $class) {
                Type::addType($type, $class);
            }
        }

        return $entityManager;
    }
}
