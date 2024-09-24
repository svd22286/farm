<?php
namespace App\Domain\Farm\Listeners;

use App\Domain\Farm\Services\Farm as FarmService;
use App\Domain\Farm\Events\HarvestCreated;
use App\Domain\Farm\Enums\AnimalType;

/**
 * Class Harvest
 *
 *
 * @package App\Domain\Farm\Listeners
 */
class Harvest
{
    /**
     * Inject FarmService
     *
     * @param  FarmService $service
     */
    public function __construct(private FarmService $service)
    {

    }

    /**
     * event handler for: 'harvest created' event
     *
     * @param  HarvestCreated $event
     * @return void
     */
    public function handle(HarvestCreated $event)
    {
        $this->service->getOneHarvest();
    }
}
