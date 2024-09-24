<?php
namespace App\Domain\Farm\Factories;

use App\Domain\Farm\Contracts\AnimalFactory;
use App\Domain\Farm\Contracts\FarmAnimal;
use App\Domain\Farm\Entities\Cow;
use App\Domain\Farm\Enums\AnimalType;
use Illuminate\Support\Str;

class CowFactory implements AnimalFactory
{
    public function createFarmAnimal(): FarmAnimal
    {
        $uuid = Str::uuid();
        return new Cow($uuid);
    }
}
