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
     * WorkflowOrganizer constructor.
     *
     * @param ImportRuleService       $filterStep
     * @param ValueConverterService   $converterStep
     * @param MappingService          $mappingStep
     * @param CsvReaderFactory        $csvReaderFactory
     * @param DoctrineWriterFactory   $doctrineWriterFactory
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
     * @var ImportRuleService
     */
    private $filterStep;

    /**
     * @var ValueConverterService
     */
    private $converterStep;

    /**
     * @var MappingService
     */
    private $mappingStep;

    /**
     * @var CsvReaderFactory
     */
    private $csvReaderFactory;

    /**
     * @var DoctrineWriterFactory
     */
    private $doctrineWriterFactory;

    /**
     * @var
     */
    private $workflow;

    /**
     * @param \SplFileObject $filename
     * @param bool    $test
     *
     * @return array
     */
    public function processCSVFile(\SplFileObject $fileObject, $test)
    {
        $this->workflow = $this->createWorkflow($this->csvReaderFactory->getReader($fileObject));

        if (!$test) {
            $this->workflow->addWriter($this->inspireDoctrineWriter());
        }

        return [
            'result' => $this->workflow->process(), 'failedOne' => $this->filterStep->getFailedOne()
        ];
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
