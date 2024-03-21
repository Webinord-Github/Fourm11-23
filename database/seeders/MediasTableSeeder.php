<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Media;

class MediasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Media::truncate();

        Media::create([
            'user_id'=>1,
            'path'=>'/storage/avatars/',
            'name'=>'coccinelle-bleue.jpg',
            'original_name' => 'coccinelle-bleue.jpg',
            'size'=>12,
            'provider'=>'jpg',
        ]);

        Media::create([
            'user_id'=>1,
            'path'=>'/storage/avatars/',
            'name'=>'coccinelle-turq.jpg',
            'original_name' => 'coccinelle-turquoise.jpg',
            'size'=>10,
            'provider'=>'jpg',
        ]);

        Media::create([
            'user_id'=>1,
            'path'=>'/storage/avatars/',
            'name'=>'coccinnelle-bleuefoncee.jpg',
            'original_name' => 'coccinelle-bleuefoncee.jpg',
            'size'=>11,
            'provider'=>'jpg',
        ]);

        Media::create([
            'user_id'=>1,
            'path'=>'/storage/avatars/',
            'name'=>'coccinnelle-jaune.jpg',
            'original_name' => 'coccinelle-jaune.jpg',
            'size'=>8,
            'provider'=>'jpg',
        ]);

        Media::create([
            'user_id'=>1,
            'path'=>'/storage/avatars/',
            'name'=>'coccinnelle-noire.jpg',
            'original_name' => 'coccinnelle-noire.jpg',
            'size'=>11,
            'provider'=>'jpg',
        ]);

        Media::create([
            'user_id'=>1,
            'path'=>'/storage/avatars/',
            'name'=>'fourmis-bleu.jpg',
            'original_name' => 'fourmis-bleu.jpg',
            'size'=>9,
            'provider'=>'jpg',
        ]);

        Media::create([
            'user_id'=>1,
            'path'=>'/storage/avatars/',
            'name'=>'fourmis-bleu-fonce.jpg',
            'original_name' => 'fourmis-bleu-fonce.jpg',
            'size'=>9,
            'provider'=>'jpg',
        ]);

        Media::create([
            'user_id'=>1,
            'path'=>'/storage/avatars/',
            'name'=>'fourmis-jaune_1.jpg',
            'original_name' => 'fourmis-jaune_1.jpg',
            'size'=>6,
            'provider'=>'jpg',
        ]);

        Media::create([
            'user_id'=>1,
            'path'=>'/storage/avatars/',
            'name'=>'fourmis-noire.jpg',
            'original_name' => 'fourmis-noire.jpg',
            'size'=>9,
            'provider'=>'jpg',
        ]);

        Media::create([
            'user_id'=>1,
            'path'=>'/storage/avatars/',
            'name'=>'libellule-bleue_1.jpg',
            'original_name' => 'libellule-bleue_1.jpg',
            'size'=>7,
            'provider'=>'jpg',
        ]);

        Media::create([
            'user_id'=>1,
            'path'=>'/storage/avatars/',
            'name'=>'libellule-turq.jpg',
            'original_name' => 'libellule-turq.jpg',
            'size'=>6,
            'provider'=>'jpg',
        ]);

        Media::create([
            'user_id'=>1,
            'path'=>'/storage/avatars/',
            'name'=>'libellule-bleuefonce_1.jpg',
            'original_name' => 'libellule-bleuefonce_1.jpg',
            'size'=>7,
            'provider'=>'jpg',
        ]);

        Media::create([
            'user_id'=>1,
            'path'=>'/storage/avatars/',
            'name'=>'libellule-jaune.jpg',
            'original_name' => 'libellule-jaune.jpg',
            'size'=>5,
            'provider'=>'jpg',
        ]);

        Media::create([
            'user_id'=>1,
            'path'=>'/storage/avatars/',
            'name'=>'libellule-noire_1.jpg',
            'original_name' => 'libellule-noire_1.jpg',
            'size'=>6,
            'provider'=>'jpg',
        ]);
    }
}
