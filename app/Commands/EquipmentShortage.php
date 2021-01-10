<?php

namespace App\Commands;

use App\Classes\EquipmentAvailabilityHelper;
use DateTime;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class EquipmentShortage extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'equipment:shortage';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Check shortage of equipments within a given date range';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $startDate = $this->ask('What is the start date? (e.g. 2019-04-11)');
        $endDate = $this->ask('What is the end date? (e.g. 2019-04-21)');

        $startDate = DateTime::createFromFormat('Y-m-d', $startDate);
        $endDate = DateTime::createFromFormat('Y-m-d', $endDate);

        $shortages = EquipmentAvailabilityHelper::getShortages($startDate, $endDate);

        if ($shortages) {
            $this->table(["Equipment", "Shortage"], $shortages);
        } else {
            $this->info("There is no shortage in any equipments within the given date range.");
        }
    }

    /**
     * Define the command's schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
