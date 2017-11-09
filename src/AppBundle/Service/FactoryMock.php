<?php

namespace AppBundle\Service;

use PHPUnit\Framework\TestCase;
use Port\Csv\CsvReader;
use Port\Csv\CsvReaderFactory;
use Port\Doctrine\DoctrineWriter;

class FactoryMock extends TestCase
{
    protected $mappingService;
    protected $importRuleService;
    protected $valueConverterService;
    protected $doctrineWriter;
    protected $workflowOrganizer;
    protected $csvReader;
    protected $fileObject;
    protected $splFile;
    


}