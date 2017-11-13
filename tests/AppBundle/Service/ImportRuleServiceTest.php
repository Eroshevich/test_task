<?php

namespace tests\AppBundle\Service;

use tests\AppBundle\Service\FactoryMock;
use PHPUnit\Framework\TestCase;

class ImportRuleServiceTest extends TestCase
{
    /**
     * @var
     */
    protected $workflowOrganizer;

    /**
     * @var
     */
    protected $savedItem;

    /**
     * @param $data
     * 
     * @dataProvider dataProvide
     */
    public function testImportRuleService($data)
    {
        $factoryMock = new FactoryMock();
        $this->workflowOrganizer = $factoryMock->createWorkflowOrganizer($data);
        $this->assertEquals($data['count'], count($this->workflowOrganizer->
        processCSVFile(new \SplFileObject('php://memory'), true)['failedItem']));
    }

    /**
     * @return array
     */
    public function dataProvide()
    {
        return [
            1 => [['row' => [
                'Product Name' => 'CPU',
                'Product Description' => 'Processing power',
                'Stock' => 10,
                'Cost in GBP' => 'Hello',
                'Product Code' => 'P0017',
                'Discontinued' => ''
            ], 'count' => 1]],
            2 => [['row' => [
                'Product Name' => 'CPU',
                'Product Description' => 'Processing power',
                'Stock' => 10,
                'Cost in GBP' => 4,
                'Product Code' => 'P0017',
                'Discontinued' => ''
            ], 'count' => 1]],
            3 => [['row' => [
                'Product Name' => 'CPU',
                'Product Description' => 'Processing power',
                'Stock' => 10,
                'Cost in GBP' => 1111,
                'Product Code' => 'P0017',
                'Discontinued' => 'yes'
            ], 'count' => 1]],
            4 => [['row' => [
                'Product Name' => 'CPU',
                'Product Description' => 'Processing power',
                'Stock' => 'why',
                'Cost in GBP' => 50,
                'Product Code' => 'P0017',
                'Discontinued' => 'yes'
            ], 'count' => 1]],
            5 => [['row' => [
                'Product Name' => 'CPU',
                'Product Description' => 'Processing power',
                'Stock' => 1,
                'Cost in GBP' => 50,
                'Product Code' => 'P0017',
                'Discontinued' => 'yes'
            ], 'count' => 1]],
            ];
    }
}