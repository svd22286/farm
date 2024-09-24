<?php
namespace App\Domain\Farm\Services;

use App\Domain\Farm\Contracts\FarmAnimal;
use App\Domain\Farm\Events\HarvestCreated;
use App\Domain\Farm\Factories\AnimalFactory;
use App\Domain\Farm\Factories\FarmAnimalFactory;
use Illuminate\Support\Collection;
use App\Domain\Farm\Enums\AnimalType;
use App\Domain\Farm\Enums\ProductType;

/**
 * Class Farm
 * @package App\Domain\Farm
 */
class Farm
{
    /**
     * @var array<string, Collection> $animals
     */
    protected array $animals = [];

    /**
     * @var array<string, array<int, int>> $harvest
     */
    protected array $harvest = [];

    /**
     * @var int $day The day of harvesting
     */
    protected static int $day = 0;

    /**
     * Adds farm animal
     *
     * @param string $animalType
     * @throws \Exception
     */
    public function addAnimal(string $animalType)
    {
        $animal = FarmAnimalFactory::getFactory($animalType)->createFarmAnimal();
        if (!isset($this->animals[$animalType])) {
            $this->animals[$animalType] = new Collection();
        }
        $this->animals[$animalType]->push($animal);

        $this->animals[$animalType] = $this->animals[$animalType]->keyBy('uuid');
    }

    /**
     * Returns harvest in 1 day
     *
     * @return \int[][]
     */
    public function getOneHarvest(): array
    {
        foreach ($this->animals as $animalType => $animalArr) {
            foreach ($animalArr as $animal) {

                $productType = $animal->getProductType();
                /**
                 * @var FarmAnimal $animal
                 */
                if (!isset($this->harvest[$productType])) {
                    $this->harvest[$productType] = [];
                }
                if (!isset($this->harvest[$productType][self::$day]))
                {
                    $this->harvest[$productType][self::$day] = [];
                }
                $animal->makeHarvest();
                $c = $animal->giveAwayHarvest();
                $this->harvest[$productType][self::$day][] = $c;
            }
        }
        self::$day++;
        return $this->harvest;
    }

    /**
     * Returns entire harvest
     *
     * @return \int[][]
     */
    public function getHarvest()
    {
        return $this->harvest;
    }

    /**
     * Returns unique ids of animals
     *
     * @return array
     */
    public function getAnimalUuids()
    {
        $uuids = [];

        foreach ($this->animals as $animalType => $animalCollection) {
            $uuids[$animalType] = $animalCollection->keys()->toArray();
        }

        return $uuids;
    }

    /**
     * Returns count animals by type
     *
     * @return array
     */
    public function getCountAnimalsByType()
    {
        $animalsByType = [];

        foreach ($this->animals as $animalType => $animalCollection) {
            $animalsByType[$animalType] = $animalCollection->count();
        }

        return $animalsByType;
    }

    /**
     * Count harvested products by type
     *
     * @param int $period
     * @return array
     */
    public function getCountProductsByType($period = 7)
    {
        $productsCountByType = [];

        $harvest = $this->harvest;
        foreach ($harvest as $productType => $products) {
            $products = collect($products);
            $products = $products->reverse();
            $key = 0;
            $productsCountByType[$productType] = $products->reduce(function (?float $carry, $harvest) use ($period, &$key) {
                if ($key < $period) {
                    $key++;
                    return $carry + array_sum($harvest);
                } else {
                    return $carry;
                }
            });
        }
        return $productsCountByType;
    }

    /**
     * Dispatch harvesting event
     */
    public function harve()
    {
        HarvestCreated::dispatch();
    }
}
