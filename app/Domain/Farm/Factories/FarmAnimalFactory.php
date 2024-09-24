<?php
namespace App\Domain\Farm\Factories;

use App\Domain\Farm\Contracts\AnimalFactory;
use App\Domain\Farm\Enums\AnimalType;
use App\Domain\Farm\Factories\CowFactory;
use App\Domain\Farm\Factories\ChickenFactory;

/**
 * Class FarmAnimalFactory
 *
 * Abstract factory for creating different farm animals
 * @package App\Domain\Farm
 */
abstract class FarmAnimalFactory
{
    /**
     * Returns a specific factory for a given animal type
     *
     * @param string $animalType
     * @return AnimalFactory
     * @throws \Exception
     */
    public static function getFactory(string $animalType): AnimalFactory
    {
        $factory = match ($animalType) {
            AnimalType::COW->value => new CowFactory(),
            AnimalType::CHICKEN->value => new ChickenFactory(),
            default => throw new \Exception('Unsupported animal'),
        };

        return $factory;
    }
}
