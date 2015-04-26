<?php
/**
 * Created by PhpStorm.
 * User: Vikram
 * Date: 26/04/15
 * Time: 7:01 AM
 */

namespace Kivi\Providers;


use Kivi\Entity\VirtualCase;

interface ProviderInterface
{
    /**
     * Returns array of virtual cases
     *
     * @param $term
     * @return VirtualCase[]
     */
    public function search($term);
} 