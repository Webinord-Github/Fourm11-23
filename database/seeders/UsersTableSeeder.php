<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::where('name', 'Super Admin')->first();
        $memberRole = Role::where('name', 'Membre')->first();
        User::truncate();

        $admin = User::create([
            'firstname' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
            'notifs_check' => '2023-10-19 18:51:37',
            'image' => '/storage/avatars/fourmis-bleue.jpg'
        ]);

        $member = User::create([
            'firstname' => 'user',
            'email' => 'user@user.com',
            'password' => bcrypt('password'),
            'notifs_check' => '2023-10-19 18:51:37',
            'image' => '/storage/avatars/fourmis-bleue.jpg'
        ]);

        $admin->roles()->attach($adminRole);
        $member->roles()->attach($memberRole);
    }
}
