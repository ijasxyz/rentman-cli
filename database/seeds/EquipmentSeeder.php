<?php

namespace Database\Seeders;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::disableQueryLog();

        $faker = \Faker\Factory::create();
        $numberOfRecords = (int) env('NUMBER_OF_RECORDS', 100000);;
        $chunk =(int) env('CHUNK', 10000);
        $numberOfRecords = $numberOfRecords > 100000 ? 100000 : $numberOfRecords;
        $chunk = $chunk > 10000 ? 10000 : $chunk;

        $this->command->info("Database seeding started (Equipments)..". PHP_EOL);

        $this->command->getOutput()->progressStart($numberOfRecords);

        for ($i = 1; $i <= $numberOfRecords / $chunk; $i++) {
            $records = Collection::times($chunk, function() use($faker){
                return [
                    'name' => $faker->name,
                    'stock' => rand(15, 30),
                ];
            })->all();

            DB::table('equipment')->insert($records);

            $this->command->getOutput()->progressAdvance($chunk);
        }

        $this->command->getOutput()->progressFinish();
    }
}
