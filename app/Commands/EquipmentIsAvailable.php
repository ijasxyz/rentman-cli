<?php

namespace App\Commands;

use App\Classes\EquipmentAvailabilityHelper;
use DateTime;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\DB;
use LaravelZero\Framework\Commands\Command;

class EquipmentIsAvailable extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'equipment:availability';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Check availability of an equipment for a requested quantity within a date range';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $id = $this->ask('What is the equipment id?');
        $quantity = $this->ask('What is the equipment quantity?');
        $startDate = $this->ask('What is the start date? (e.g. 2019-04-11)');
        $endDate = $this->ask('What is the end date? (e.g. 2019-04-21)');

        $startDate = DateTime::createFromFormat('Y-m-d', $startDate);
        $endDate = DateTime::createFromFormat('Y-m-d', $endDate);

        $isAvailable = EquipmentAvailabilityHelper::isAvailable($id, $quantity, $startDate, $endDate);

        if ($isAvailable) {
            $this->info("The requested quantity is available within the given date range.");
        } else {
            $this->warn("The requested quantity is not available within the given date range.");
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
