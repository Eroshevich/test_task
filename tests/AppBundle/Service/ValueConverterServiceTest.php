<?php

namespace tests\AppBundle\Service;

use PHPUnit\Framework\TestCase;
use AppBundle\Service\FactoryMock;

class ValueConverterServiceTest extends TestCase
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
    public function testValueConverterService($data)
    {
        $factoryMock = new FactoryMock();
        $this->workflowOrganizer = $factoryMock->createWorkflowOrganizer($data);
        $this->workflowOrganizer->processCSVFile(new \SplFileObject('php://memory'), true);
        $date = new \DateTime($this->savedItem['dateTimeDiscontinued']);
        if ($data['isDateTime']) {
            $this->assertInstanceOf(\DateTime::class, $date);
        } else {
            $this->assertEquals($this->savedItem['dateTimeDiscontinued'], $data['row']['Discontinued']);
        }
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
                'Cost in GBP' => 15,
                'Product Code' => 'P0017',
                'Discontinued' => 'yes'
            ], 'isDateTime' => true]],
            2 => [['row' => [
                'Product Name' => 'CPU',
                'Product Description' => 'Processing power',
                'Stock' => 10,
                'Cost in GBP' => 4,
                'Product Code' => 'P0017',
                'Discontinued' => ''
            ], 'isDateTime' => false]],
            3 => [['row' => [
                'Product Name' => 'CPU',
                'Product Description' => 'Processing power',
                'Stock' => 10,
                'Cost in GBP' => 10,
                'Product Code' => 'P0017',
                'Discontinued' => ''
            ], 'isDateTime' => false]],
        ];
    }
}