<?php

namespace AppBundle\Service;

use Port\Steps\Step\FilterStep;
use Port\Steps\StepAggregator as Workflow;

/**
 * Class ImportRuleService
 * @package AppBundle\Service
 */
class ImportRuleService
{

    /**
     * @var array
     */
    private $failedOne = [];

    /**
     * @return array
     */
    public function getFailedOne()
    {
        return $this->failedOne;
    }

    /**
     * @return FilterStep
     */
    public function generateFilter()
    {
        $filter = new FilterStep();
        
        return $filter->add(function ($input) {
            
            return $this->isValidInput($input);
        });
    }

    /**
     * @param $value
     *
     * @return bool
     */
    private function isValidCost($value)
    {
        return is_numeric($value) && $value >= 5 && $value <= 1000;
    }

    /**
     * @param $value
     *
     * @return bool
     */
    private function isValidStock($value)
    {
        return is_numeric($value) && $value >= 10;
    }

    /**
     * @param $value
     *
     * @return bool
     */
    private function isValidDiscontinued($value)
    {
        return $value == 'yes' || $value == '';
    }

    /**
     * @param $input
     *
     * @return bool
     */
    private function isValidInput($input)
    {
        if ($this->isValidCost($input['cost'])
            && $this->isValidStock($input['stock'])
            && $this->isValidDiscontinued($input['dateTimeDiscontinued'])
        ) {
           
            return true;
        } else {
            $this->failedOne[] = $input;
            
            return false;
        }
    }
}