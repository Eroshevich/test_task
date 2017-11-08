<?php

namespace AppBundle\Service;

use Port\Steps\Step\ConverterStep;
use Port\Steps\Step;
use DateTime;

/**
 * Class ValueConverterService
 * @package AppBundle\Service
 */
class ValueConverterService
{
    /**
     * @return ConverterStep
     */
    public function inspireConvert()
    {
        $convertStep = new ConverterStep();
        $convertStep->add(function($input) 
        { 
            return $this->updateDiscontinuedValue($input); 
        });
        
        return $convertStep;
    }

/**
     * @param $input
     *
     * @return mixed
     */
    private function updateDiscontinuedValue($input)
    {
        $input['DateTimeDiscontinued'] == 'yes' ? new DateTime() : null;
        
        return $input;
    }
}