<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Avatar;

class AvatarsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Avatar::create([
            'url' => 'coccinelle-bleue.jpg'
        ]);
        Avatar::create([
            'url' => 'coccinelle-turq.jpg'
        ]);
        Avatar::create([
            'url' => 'coccinnelle-bleuefoncee.jpg'
        ]);
        Avatar::create([
            'url' => 'coccinnelle-jaune.jpg'
        ]);
        Avatar::create([
            'url' => 'coccinnelle-noire.jpg'
        ]);
        Avatar::create([
            'url' => 'fourmis-bleu-fonce.jpg'
        ]);
        Avatar::create([
            'url' => 'fourmis-bleu.jpg'
        ]);
        Avatar::create([
            'url' => 'fourmis-jaune_1.jpg'
        ]);
        Avatar::create([
            'url' => 'fourmis-noire.jpg'
        ]);
        Avatar::create([
            'url' => 'libellule-bleue_1.jpg'
        ]);
        Avatar::create([
            'url' => 'libellule-bleuefonce_1.jpg'
        ]);
        Avatar::create([
            'url' => 'libellule-jaune.jpg'
        ]);
        Avatar::create([
            'url' => 'libellule-noire_1.jpg'
        ]);
        Avatar::create([
            'url' => 'libellule-turq.jpg'
        ]);

    }
}
