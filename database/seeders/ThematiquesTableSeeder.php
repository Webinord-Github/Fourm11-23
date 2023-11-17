<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Thematique;

class ThematiquesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Thematique::truncate();

        Thematique::create(['name'=>'Intersectionnalité']);
        Thematique::create(['name'=>'Le cyberespace']);
        Thematique::create(['name'=>'Microagression']);
        Thematique::create(['name'=>'Grossophobie']);
        Thematique::create(['name'=>'Capacitisme']);
        Thematique::create(['name'=>'Sexisme']);
        Thematique::create(['name'=>'Racisme']);
        Thematique::create(['name'=>'Homophobie']);
        Thematique::create(['name'=>'Transphobie']);
        Thematique::create(['name'=>'Classisme']);
        Thematique::create(['name'=>'Âgisme']);
        Thematique::create(['name'=>'Adultisme']);
        Thematique::create(['name'=>'Enfants']);
        Thematique::create(['name'=>'Adolescent·es']);
        Thematique::create(['name'=>'Aîné·es']);
        Thematique::create(['name'=>'École primaire']);
        Thematique::create(['name'=>'École secondaire']);
        Thematique::create(['name'=>'Milieux de vie aîné·es']);
        Thematique::create(['name'=>'Milieux de loisirs aîné·es']);
        Thematique::create(['name'=>'Milieux de loisirs jeunesse']);
        Thematique::create(['name'=>'Équipes sportives']);
    }
}
