<?php

namespace AppBundle\Service;

use Port\Steps\Step\MappingStep;

/**
 * Class MappingService
 * @package AppBundle\Service
 */
class MappingService
{
    /**
     * @return MappingStep
     */
    public function generateMapping()
    {
        $mappingStep = new MappingStep();

        $mappingStep->map('[Product Code]', '[productCode]');
        $mappingStep->map('[Product Name]', '[name]');
        $mappingStep->map('[Product Description]', '[description]');
        $mappingStep->map('[Stock]', '[stock]');
        $mappingStep->map('[Cost in GBP]', '[cost]');
        $mappingStep->map('[Discontinued]', '[dateTimeDiscontinued]');

        return $mappingStep;
    }
}

