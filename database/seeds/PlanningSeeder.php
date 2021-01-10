<?php

namespace Database\Seeders;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlanningSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::disableQueryLog();

        $numberOfRecords = (int) env('NUMBER_OF_RECORDS', 1000000);;
        $chunk =(int) env('CHUNK', 10000);
        $numberOfRecords = $numberOfRecords > 1000000 ? 1000000 : $numberOfRecords;
        $chunk = $chunk > 10000 ? 10000 : $chunk;

        $numberOfEquipments = DB::table('equipment')->count();

        $this->command->info("Database seeding started (Planning)..". PHP_EOL);

        $this->command->getOutput()->progressStart($numberOfRecords);

        for ($i = 1; $i <= $numberOfRecords / $chunk; $i++) {
            $records = Collection::times($chunk, function() use($numberOfEquipments){
                $equipment = DB::table('equipment')->where('id', rand(1, $numberOfEquipments))->limit(1)->first();
                $startsIn = rand(1, 30);
                $noOfDays = rand(0, 20);

                return [
                    'equipment' => $equipment->id,
                    'quantity' => rand(1, $equipment->stock),
                    'start' => today()->addDays($startsIn),
                    'end' => today()->addDays($startsIn + $noOfDays),
                ];
            })->all();

            DB::table('planning')->insert($records);

            $this->command->getOutput()->progressAdvance($chunk);
        }

        $this->command->getOutput()->progressFinish();
    }
}
