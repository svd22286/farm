<?php
namespace App\Domain\Farm\Services;

class Statistic
{
    public function __construct(protected Farm $farmService)
    {

    }

    /**
     * Returns count animals by type
     *
     * @return array
     */
    public function getCountAnimalsByType()
    {
        $animalsByType = [];

        foreach ($this->farmService->getAnimals() as $animalType => $animalCollection) {
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

        $harvest = $this->farmService->getHarvest();
        foreach ($harvest as $productType => $products) {
            $products = collect($products);
            $products = $products->reverse();
            $key = 0;
            $productsCountByType[$productType] = $products->reduce(function (?float $carry, $harvest) use ($period, &$key) {
                if ($key < $period) {
                    $key++;
                    return $carry + array_sum($harvest);
                }
                return $carry;
            });
        }
        return $productsCountByType;
    }
}
