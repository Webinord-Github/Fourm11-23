<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CardSection;

class CardsSectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CardSection::truncate();
        CardSection::create(['name'=>'Composantes']);
        CardSection::create(['name'=>'Rôles']);
        CardSection::create(['name'=>'Interventions']);
        CardSection::create(['name'=>'Conséquences']);
    }
}
