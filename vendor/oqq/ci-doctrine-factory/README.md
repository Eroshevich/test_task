Configuration Example

```php
<?php

return [
    'dependencies' => [
        'invokables' => [
            \Gedmo\Translatable\TranslatableListener::class => \Gedmo\Translatable\TranslatableListener::class,
        ],
        'factories' => [
            Doctrine\Common\Cache\Cache::class => Oqq\DoctrineFactory\DoctrineCacheFactory::class,
            Doctrine\ORM\EntityManagerInterface::class  => Oqq\DoctrineFactory\DoctrineEntityManagerFactory::class,
        ],
    ],
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'driver'   => 'pdo_mysql',
                'host'     => 'db',
                'port'     => '3306',
                'dbname'   => 'orm_test',
                'user'     => 'root',
                'password' => '',
                'charset'  => 'UTF8',
            ]
        ],
        'orm' => [
            'event_subscribers' => [
                \Gedmo\Translatable\TranslatableListener::class,
            ]
        ],
        'cache' => [
            'redis' => [
                'host' => 'cache',
                'port' => 6379
            ],
        ],
    ],
];

```
