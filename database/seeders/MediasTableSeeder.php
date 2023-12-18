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
            'name'=>'coccinelle-turquoise.jpg',
            'original_name' => 'coccinelle-turquoise.jpg',
            'size'=>10,
            'provider'=>'jpg',
        ]);

        Media::create([
            'user_id'=>1,
            'path'=>'/storage/avatars/',
            'name'=>'coccinelle-bleuefoncee.jpg',
            'original_name' => 'coccinelle-bleuefoncee.jpg',
            'size'=>11,
            'provider'=>'jpg',
        ]);

        Media::create([
            'user_id'=>1,
            'path'=>'/storage/avatars/',
            'name'=>'coccinelle-jaune.jpg',
            'original_name' => 'coccinelle-jaune.jpg',
            'size'=>8,
            'provider'=>'jpg',
        ]);

        Media::create([
            'user_id'=>1,
            'path'=>'/storage/avatars/',
            'name'=>'coccinelle-noire.jpg',
            'original_name' => 'coccinelle-noire.jpg',
            'size'=>11,
            'provider'=>'jpg',
        ]);

        Media::create([
            'user_id'=>1,
            'path'=>'/storage/avatars/',
            'name'=>'fourmis-bleue.jpg',
            'original_name' => 'fourmis-bleue.jpg',
            'size'=>9,
            'provider'=>'jpg',
        ]);

        Media::create([
            'user_id'=>1,
            'path'=>'/storage/avatars/',
            'name'=>'fourmis-turquoise.jpg',
            'original_name' => 'fourmis-turquoise.jpg',
            'size'=>8,
            'provider'=>'jpg',
        ]);

        Media::create([
            'user_id'=>1,
            'path'=>'/storage/avatars/',
            'name'=>'fourmis-bleuefoncee.jpg',
            'original_name' => 'fourmis-bleuefoncee.jpg',
            'size'=>9,
            'provider'=>'jpg',
        ]);

        Media::create([
            'user_id'=>1,
            'path'=>'/storage/avatars/',
            'name'=>'fourmis-jaune.jpg',
            'original_name' => 'fourmis-jaune.jpg',
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
            'name'=>'libellule-bleue.jpg',
            'original_name' => 'libellule-bleue.jpg',
            'size'=>7,
            'provider'=>'jpg',
        ]);

        Media::create([
            'user_id'=>1,
            'path'=>'/storage/avatars/',
            'name'=>'libellule-turquoise.jpg',
            'original_name' => 'libellule-turquoise.jpg',
            'size'=>6,
            'provider'=>'jpg',
        ]);

        Media::create([
            'user_id'=>1,
            'path'=>'/storage/avatars/',
            'name'=>'libellule-bleuefoncee.jpg',
            'original_name' => 'libellule-bleuefoncee.jpg',
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
            'name'=>'libellule-noire.jpg',
            'original_name' => 'libellule-noire.jpg',
            'size'=>6,
            'provider'=>'jpg',
        ]);
    }
}
