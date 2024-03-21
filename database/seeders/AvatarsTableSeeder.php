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
        Avatar::truncate();
        Avatar::create([
            'path' => 'coccinelle-bleue.jpg'
        ]);
        Avatar::create([
            'path' => 'coccinelle-turq.jpg'
        ]);
        Avatar::create([
            'path' => 'coccinnelle-bleuefoncee.jpg'
        ]);
        Avatar::create([
            'path' => 'coccinnelle-jaune.jpg'
        ]);
        Avatar::create([
            'path' => 'coccinnelle-noire.jpg'
        ]);
        Avatar::create([
            'path' => 'fourmis-bleu-fonce.jpg'
        ]);
        Avatar::create([
            'path' => 'fourmis-bleu.jpg'
        ]);
        Avatar::create([
            'path' => 'fourmis-jaune_1.jpg'
        ]);
        Avatar::create([
            'path' => 'fourmis-noire.jpg'
        ]);
        Avatar::create([
            'path' => 'libellule-bleue_1.jpg'
        ]);
        Avatar::create([
            'path' => 'libellule-bleuefonce_1.jpg'
        ]);
        Avatar::create([
            'path' => 'libellule-jaune.jpg'
        ]);
        Avatar::create([
            'path' => 'libellule-noire_1.jpg'
        ]);
        Avatar::create([
            'path' => 'libellule-turq.jpg'
        ]);

    }
}
