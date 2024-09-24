<?php
namespace App\Domain\Farm\Listeners;

use App\Domain\Farm\Services\Farm as FarmService;
use Illuminate\Console\Events\CommandStarting;
use App\Domain\Farm\Enums\AnimalType;

/**
 * Class InitFarm
 *
 * Start conditions
 * @package App\Domain\Farm\Listeners
 */
class InitFarm
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
     * Init farm: generate 10 cows & 20 chickens
     *
     * @param  CommandStarting $event
     * @return void
     */
    public function handle(CommandStarting $event)
    {
        if ($event->command == 'farm:life') {
            $i = 10;
            while ($i--) {
                $this->service->addAnimal(AnimalType::COW->value);
            }

            $i = 20;
            while ($i--) {
                $this->service->addAnimal(AnimalType::CHICKEN->value);
            }
        }
    }
}
