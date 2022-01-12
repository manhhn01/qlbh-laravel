<?php

namespace Database\Seeders;

use App\Models\Statistic;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class StatisticSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $last_record = Statistic::latest()->first();
        $time = $last_record ? new Carbon($last_record->created_at): Carbon::now()->subMonth(2);

        for($i=0; $i<100; $i++)
        {
            Statistic::factory()->create([
                'created_at' => $time->addDay(),
            ]);
        }
    }
}

