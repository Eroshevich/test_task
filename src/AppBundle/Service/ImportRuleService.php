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
     * @return FilterStep
     */
    public function inspireFilter()
    {
        $filter = new FilterStep();
        
        return $filter->add(function ($input) {
            
            return $this->FinishInput($input);
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
    private function FinishInput($input)
    {
        if ($this->isValidCost($input['Cost'])
            && $this->isValidStock($input['Stock'])
            && $this->isValidDiscontinued($input['DateTimeDiscontinued'])
        ) {
           
            return true;
        } else {
            $this->failedOne[] = $input;
            
            return false;
        }
    }

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
}