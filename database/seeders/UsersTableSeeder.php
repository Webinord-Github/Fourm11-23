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
<<<<<<< HEAD
        $memberRole = Role::where('name', 'Membre')->first();
=======
        $memberRole = Role::where('name', 'member')->first();
>>>>>>> mick-local
        User::truncate();

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
<<<<<<< HEAD
            'notifs_check' => '2023-10-19 18:51:37',
            'verified' => 1,
=======
            'notifs_check' => '2023-10-19 18:51:37'
>>>>>>> mick-local
        ]);

        $member = User::create([
            'name' => 'user',
            'email' => 'user@user.com',
            'password' => bcrypt('password'),
<<<<<<< HEAD
            'notifs_check' => '2023-10-19 18:51:37',
            'verified' => 1,
=======
            'notifs_check' => '2023-10-19 18:51:37'
>>>>>>> mick-local
        ]);

        $admin->roles()->attach($adminRole);
        $member->roles()->attach($memberRole);
    }
}
