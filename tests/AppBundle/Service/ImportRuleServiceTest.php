<?php

namespace tests\AppBundle\Service;

use AppBundle\Service\FactoryMock;
use PHPUnit\Framework\TestCase;

class ImoprtRuleServiceTest extends TestCase
{
    /**
     * @var
     */
    protected $workflowOrganizer;

    /**
     * @param $data
     */
    public function testFilterCSVFile($data)
    {
        $factoryMock = new FactoryMock();
        $this->workflowOrganizer = $factoryMock->createWorkflowOrganizer($data);
        $this->assertEquals($data['count'], count($this->workflowOrganizer->
        processCSVFile(new \SplFileObject('php://memory'), true)['failedOne']));
    }
}