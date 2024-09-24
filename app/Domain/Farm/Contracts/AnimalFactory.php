<?php
namespace App\Domain\Farm\Contracts;

/**
 * Interface AnimalFactory
 * @package App\Domain\Farm
 */
interface AnimalFactory
{
    public function createFarmAnimal(): FarmAnimal;
}
