<?php

namespace AppBundle\Service;

use Port\Doctrine\DoctrineWriter;
use Doctrine\ORM\EntityManager;

class DoctrineWriterFactory
{
    private $em;
    
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    
    public function getDoctrineWriter($objectName)
    {
        return new DoctrineWriter($this->em, $objectName);
    }
}