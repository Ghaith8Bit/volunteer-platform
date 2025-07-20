<?php

namespace Database\Seeders;

use App\Models\Opportunity;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OpportunitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            Opportunity::create([
                'title' => "Opportunity #$i",
                'description' => "Description for opportunity $i",
                'location' => "City $i",
                'start_date' => Carbon::now()->addDays($i),
                'end_date' => Carbon::now()->addDays($i + 5),
                'organizer_id' => 2,
                'status' => 'approved',
            ]);
        }
    }
}
