<?php
namespace App\Domain\Farm\Contracts;

/**
 * Interface FarmAnimal
 *
 * Describes 'farm animal' methods class
 * @package App\Domain\Farm
 */
interface FarmAnimal
{
    /**
     * harvest in 1 day
     *
     * @return $this
     */
    public function makeHarvest(): self;

    /**
     * Returns type of animal
     *
     * @return string
     */
    public function getType(): string;

    /**
     * Returns type of product
     *
     * @return string
     */
    public function getProductType(): string;

    /**
     * Give away harvest
     *
     * @return int
     */
    public function giveAwayHarvest(): int;

    /**
     * Set unique number of animal
     *
     * @return string
     */
    public function getUuid(): string;
}
