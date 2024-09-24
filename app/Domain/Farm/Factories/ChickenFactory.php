<?php
namespace App\Domain\Farm\Factories;

use App\Domain\Farm\Contracts\AnimalFactory;
use App\Domain\Farm\Contracts\FarmAnimal;
use App\Domain\Farm\Entities\Chicken;
use App\Domain\Farm\Enums\AnimalType;
use Illuminate\Support\Str;

class ChickenFactory implements AnimalFactory
{
    public function createFarmAnimal(): FarmAnimal
    {
        $uuid = Str::uuid();
        return new Chicken($uuid);
    }
}
