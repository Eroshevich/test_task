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
    public function inspireMapping()
    {
        $workflow = new MappingStep();

        $workflow->map('[Product Code]', '[ProductCode]');
        $workflow->map('[Product Name]', '[Name]');
        $workflow->map('[Product Description]', '[Description]');
        $workflow->map('[Stock]', '[Stock]');
        $workflow->map('[Cost in GBP]', '[Cost]');
        $workflow->map('[Discontinued]', '[DateTimeDiscontinued]');

        $workflow->process();

        return $workflow;
    }
}

