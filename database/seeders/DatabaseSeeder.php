<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RolesTableSeeder::class,
            UsersTableSeeder::class,
            PagesTableSeeder::class,
            ThematiquesTableSeeder::class,
            automatic_emails_seeder::class,
            AvatarsTableSeeder::class,
            MediasTableSeeder::class,
            MaintenanceTableSeeder::class,
            SmtpTableSeeder::class,
        ]);
    }
}
