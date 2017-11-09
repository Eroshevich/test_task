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

    public function testAClassUsingObjectFactory()
    {
        $fooStub = $this->getMock('Foo');
        $barStub = $this->getMock('Bar');

        $factoryMock = $this->getMock('Factory');

        $factoryMock->expects($this->any())
            ->method('getInstanceFor')
            ->with('foo')
            ->will($this->returnValue($fooStub));

        $factoryMock->expects($this->any())
            ->method('getInstanceFor')
            ->with('bar')
            ->will($this->returnValue($barStub));
    }


}