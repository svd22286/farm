<?php
namespace App\Domain\Farm\Entities;

use App\Domain\Farm\Enums\AnimalType;
use App\Domain\Farm\Enums\ProductType;
use App\Domain\Farm\Contracts\FarmAnimal;

/**
 * Class Cow
 * @package App\Domain\Farm
 */
class Cow implements FarmAnimal
{
    public function __construct(public string $uuid)
    {

    }

    /**
     * @var int $harvest
     */
    public $harvest;

    /**
     * @inheritDoc
     */
    public function makeHarvest(): self
    {
        $this->harvest = mt_rand(8, 12);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getType(): string
    {
        return AnimalType::COW->value;
    }

    /**
     * @inheritDoc
     */
    public function getProductType(): string
    {
        return ProductType::MILK->value;
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
