<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\MailSetting;
class MailSettingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $mailSettings = MailSetting::getHostAndPort();

        config([
            'mail.driver' => 'smtp',
            'mail.host' => $mailSettings['host'],
            'mail.port' => $mailSettings['port'],
            'mail.username' => $mailSettings['username'],
            'mail.password' => $mailSettings['password'],
            'mail.encryption' => $mailSettings['encryption'],
        ]);
    }
}
