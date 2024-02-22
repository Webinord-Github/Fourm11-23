<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'host',
        'port',
        'username',
        'password',
        'encryption',
    ];

    public static function getHostAndPort()
    {
        $mailSetting = self::first(); // Assuming you want the values from the first record in the table

        if ($mailSetting) {
            return [
                'host' => $mailSetting->host,
                'port' => $mailSetting->port,
                'username' => $mailSetting->username,
                'password' => $mailSetting->password,
                'encryption' => $mailSetting->encryption,
            ];
        }

        // Return default values or handle the case when no record is found
        return [
            'host' => 'default_host',
            'port' => 'default_port',
            'username' => 'default_username',
            'password' => 'default_password',
            'encryption' => 'default_encryption',
        ];
    }
}
