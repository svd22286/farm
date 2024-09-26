<?php
namespace App\Domain\Farm\Commands;

use App\Domain\Farm\Services\Farm as FarmService;
use Illuminate\Console\Command;
use App\Domain\Farm\Enums\AnimalType;

/**
 * Class Farm
 * @package App\Domain\Farm
 */
class Farm extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'farm:life';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Emulates life on a farm';

    /**
     * Add animals
     *
     * @param FarmService $service
     * @param array<int,array<string,int>> $animals Describes animal types & count to be added
     */
    private function addAnimals(FarmService $service, array $animals): void
    {
        array_walk($animals, function ($item, $key) use ($service) {
            while ($item[1]--) {
                $service->addAnimal($item[0]);
            }
        });
    }

    /**
     * Harvesting
     *
     * @param FarmService $service
     * @param int $count
     */
    private function harve(FarmService $service, $count = 7)
    {
        while ($count-- > 0) {
            $service->harve();
        }
    }

    /**
     * Auxiliary method to print text
     *
     * @param $arr
     * @param string $title
     */
    private function report($arr, $title = '')
    {
        $keys = array_keys($arr);
        $values = array_values($arr);

        $keys = array_map(function ($val) {
            return str_pad($val, 30, " ");
        }, $keys);

        $values = array_map(function ($val) {
            return str_pad($val, 30, " ");
        }, $values);

        if ($title) {
            $title = str_pad($title, 60, ' ');
            $this->info($title);
        }

        $line = array_reduce($keys, function ($carry, $str) {
            return $carry . $str;
        }, "");
        $this->line("<bg=black;fg=red>" . $line . "</>");

        $line = array_reduce($values, function ($carry, $str) {
            return $carry . $str;
        }, "");
        $this->line("<bg=black;fg=green>" . $line . "</>");
        $this->line("<bg=white;fg=red>" . str_repeat("-",30 * count($keys)) . "</>");
        $this->line(" ");
    }

    /**
     * Execute the console command.
     */
    public function handle(FarmService $service)
    {
        // step 1
        $this->addAnimals($service, [
            [(string)AnimalType::COW->value, 10],
            [(string)AnimalType::CHICKEN->value, 20]
        ]);

        // step 2
        $animalsInfo = $service->getCountAnimalsByType();
        $this->report($animalsInfo, 'Число животных на ферме');

        // step 3
        $this->harve($service);

        // step 4
        $productsInfo = $service->getCountProductsByType();
        $this->report($productsInfo, 'Продукция собранная за первую неделю');

        // step 5
        $this->addAnimals($service, [
            [AnimalType::COW->value, 1],
            [AnimalType::CHICKEN->value, 5]
        ]);

        // step 6
        $animalsInfo = $service->getCountAnimalsByType();
        $this->report($animalsInfo, 'Количество животных после похода на рынок');

        // step 7
        $this->harve($service);
        $productsInfo = $service->getCountProductsByType();
        $this->report($productsInfo, 'Собрано продуктов за вторую неделю');

        // adding 3 goats & harvesting 5 times of goat milk
        $this->addAnimals($service, [
            [AnimalType::GOAT->value, 3],
        ]);
        $animalsInfo = $service->getCountAnimalsByType();
        $this->report($animalsInfo, 'Количество животных после второго похода на рынок');
        $this->harve($service);
        $productsInfo = $service->getCountProductsByType(5);
        $this->report($productsInfo, 'Собрано продуктов за 5 дней третьей недели');
    }
}
