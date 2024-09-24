<?php
namespace App\Domain\Farm\Entities;

use App\Domain\Farm\Enums\AnimalType;
use App\Domain\Farm\Enums\ProductType;
use App\Domain\Farm\Contracts\FarmAnimal;

/**
 * Class Chicken
 * @package App\Domain\Farm
 */
class Chicken implements FarmAnimal
{
    public function __construct(public string $uuid)
    {

    }

    public $harvest;

    /**
     * @inheritDoc
     */
    public function makeHarvest(): self
    {
        $this->harvest = mt_rand(0, 1);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getType(): string
    {
        return AnimalType::CHICKEN->value;
    }

    /**
     * @inheritDoc
     */
    public function getProductType(): string
    {
        return ProductType::EGG->value;
    }

    /**
     * @inheritDoc
     */
    public function giveAwayHarvest(): int
    {
        $harvest = $this->harvest;
        $this->harvest = null;
        return $harvest;
    }

    /**
     * @inheritDoc
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }
}
