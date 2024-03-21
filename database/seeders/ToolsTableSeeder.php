<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tool;

class ToolsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tool::truncate();

        Tool::create([
            'user_id'=>1,
            'path'=>'/storage/avatars/',
            'name'=>'coccinelle-bleue.jpg',
            'original_name' => 'coccinelle-bleue.jpg',
            'size'=>12,
            'provider'=>'jpg',
        ]);
    }
}
