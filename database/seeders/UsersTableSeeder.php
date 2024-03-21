<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Carbon;

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

        User::truncate();

        $admin = User::create([
            'firstname' => 'Admin',
            'email' => 'olivier.lauzon1209@outlook.com',
            'password' => bcrypt('password'),
            'notifs_check' => '2023-10-19 18:51:37',
            'image_id' => 1,
            'approved_email' => true,
            'refused_email' => true,
        ]);

        $admin2 = User::create([
            'firstname' => 'Olivier',
            'lastname' => 'Lauzon',
            'pronoun' => 'Il',
            'used_agreements' => 'Mr',
            'gender' => 'Homme',
            'title' => 'Owner',
            'environment' => 'Webinord',
            'birthdate' => Carbon::createFromFormat('d/m/Y', '29/12/1997')->format('Y-m-d'),
            'years_xp' => '5',
            'work_city' => 'Grand Montréal',
            'work_phone' => '000-000-0000',
            'description' => 'Consultation numérique et services web',
            'audience' => 'N/D',
            'interests' => 'N/D',
            'hear_about' => 'N/D',
            'newsletter' => true,
            'notifications' => true,
            'conditions' => true,
            'email' => 'info@webinord.ca',
            'password' => bcrypt('password'),
            'notifs_check' => '2023-10-19 18:51:37',
            'image_id' => 1,
            'approved_email' => true,
            'refused_email' => true,
        ]);



        $admin->roles()->attach($adminRole);
        $admin2->roles()->attach($adminRole);

    }
}
