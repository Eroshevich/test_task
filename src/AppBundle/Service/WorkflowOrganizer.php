<?php

namespace AppBundle\Service;

use Port\Csv\CsvReaderFactory;
use Port\Csv\CsvReader;
use Port\Steps\StepAggregator as Workflow;
use AppBundle\Entity\Product;

/**
 * Class WorkflowOrganizer
 * @package AppBundle\Service
*/
class WorkflowOrganizer
{
    /**
     * @var ImportRuleService
     */
    private $filterStep;

    /**
     * @var MappingService
     */
    private $mappingStep;

    /**
     * @var ValueConverterService
     */
    private $converterStep;

    /**
     * @var CsvReaderFactory
     */
    private $csvReaderFactory;

    /**
     * @var DoctrineWriterFactory
     */
    private $doctrineWriterFactory;


    /**
     * WorkflowOrganizer constructor.
     *
     * @param ImportRuleService      $filterStep
     * @param ValueConverterService  $converterStep
     * @param MappingService         $mappingStep
     * @param CsvReaderFactory       $csvReaderFactory
     * @param DoctrineWriterFactory  $doctrineWriterFactory
     */
    public function __construct(
        ImportRuleService $filterStep,
        ValueConverterService $converterStep,
        MappingService $mappingStep,
        CsvReaderFactory $csvReaderFactory,
        DoctrineWriterFactory $doctrineWriterFactory
    ) {
        $this->filterStep = $filterStep;
        $this->converterStep = $converterStep;
        $this->mappingStep = $mappingStep;
        $this->csvReaderFactory = $csvReaderFactory;
        $this->doctrineWriterFactory = $doctrineWriterFactory;
    }

    /**
     * @param CsvReader $reader
     *
     * @return Workflow
     */
    private function createWorkflow($reader)
    {
        $workflow = new Workflow($reader);
        $workflow->addStep($this->mappingStep->inspireMapping());
        $workflow->addStep($this->filterStep->inspireFilter());
        $workflow->addStep($this->converterStep->inspireConvert());

        return $workflow;
    }

    /**
     * @param \SplFileObject $fileObject
     * @param bool   $test
     *
     * @return array
     */
    public function processCSVFile(\SplFileObject $fileObject)
    {
        $this->workflow = $this->createWorkflow($this->csvReaderFactory->getReader($fileObject));

        return ['result' => $this->workflow->process(), 'failedOne' => $this->filterStep->getFailedOne()];
    }

    /**
     * @return \Port\Doctrine\DoctrineWriter
     */
    private function inspireDoctrineWriter()
    {
        $writer = $this->doctrineWriterFactory->getDoctrineWriter(Product::class);
        $writer->prepare();

        return $writer;
    }
    
}
