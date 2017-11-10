<?php

namespace AppBundle\Service;

use PHPUnit\Framework\TestCase;
use Port\Csv\CsvReader;
use Port\Csv\CsvReaderFactory;
use Port\Doctrine\DoctrineWriter;

class FactoryMock extends TestCase
{
    protected $csvReaderFactory;
    protected $doctrineWriterFactory;
    protected $importRuleService;
    protected $valueConverterService;
    protected $mappingService;
    protected $workflowOrganizer;
    protected $fileObject;
    protected $csvReader;
    protected $doctrineWriter;
    protected $splFile;
    protected $savedItem;

    /**
     * @param $data
     *
     * @return WorkflowOrganizer
     */
    public function createWorkflowOrganizer($data)
    {
        $this->importRuleService = new ImportRuleService();
        $this->valueConverterService = new ValueConverterService();
        $this->mappingService = new MappingService();
        $this->csvReaderFactory = $this->getMockBuilder(CsvReaderFactory::class)
            ->setMethods(['getReader'])
            ->getMock();
        $this->csvReader = $this->getMockBuilder(CsvReader::class)
            ->disableOriginalConstructor()
            ->setMethods(['current', 'rewind', 'valid', 'key', 'next', 'count', 'seek'])
            ->getMock();
        $this->csvReader
            ->method('current')
            ->willReturn($data['row']);
        $this->csvReader->expects($this->exactly(2))
            ->method('valid')
            ->will($this->onConsecutiveCalls(true, false));
        $this->csvReader
            ->method('key')
            ->willReturn(0);
        $this->csvReader->expects($this->exactly(1))
            ->method('next')
            ->willReturn(null);
        $this->csvReader
            ->method('count')
            ->willReturn(1);
        $this->csvReaderFactory->expects($this->once())->method('getReader')->willReturn($this->csvReader);
        $this->doctrineWriterFactory = $this->createMock(DoctrineWriterFactory::class);
        $this->doctrineWriter = $this->getMockBuilder(DoctrineWriter::class)
            ->disableOriginalConstructor()
            ->setMethods(['writeItem'])
            ->getMock();
        $this->doctrineWriter->expects($this->once())
            ->method('writeItem')
            ->willReturnCallback(function($item) {
                $this->savedItem = $item;
            });
        $this->workflowOrganizer = new WorkflowOrganizer(
            $this->importRuleService,
            $this->valueConverterService,
            $this->mappingService,
            $this->csvReaderFactory,
            $this->doctrineWriterFactory
        );
        return $this->workflowOrganizer;
    }
 }