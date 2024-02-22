<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MailSetting;

class SmtpTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MailSetting::truncate();
        MailSetting::create([
            'host' => 'smtp.gmail.com',
            'port' => '587',
            'username' => 'info@webinord.ca',
            'password' => 'atuvbuuyyuxnlehq',
            'encryption' => 'ssl',
        ]);
    }
}
