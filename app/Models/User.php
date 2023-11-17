<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Fortify\TwoFactorAuthenticatable;


class User extends Authenticatable

{
    use HasApiTokens, HasFactory, Notifiable, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'notifs_check',
        'verified',
        'image',
        'ban',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function pages()
    {
        return $this->hasMany('App\Models\Page');
    }

    public function notification()
    {
        return $this->hasOne('App\Models\Notification');
    }

    public function conversations()
    {
        return $this->hasMany('App\Models\Conversation');
    }

    public function replies()
    {
        return $this->hasMany('App\Models\Reply');
    }

    public function medias()
    {
        return $this->hasMany('App\Models\Media');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Models\Role');
    }

    public function messages()
    {
        return $this->belongsToMany('App\Models\Message');
    }

    public function isAdmin()
    {
        return $this->hasAnyRole(['Super Admin', 'Admin']);
    }

    public function isAuth()
    {
        return $this->Auth()->check();
    }

    public function hasAnyRole($roles)
    {
        return null != $this->roles()->whereIn('name', $roles)->first();
    }

    public function hasRole($role)
    {
        return null != $this->roles()->where('name', $role)->first();
    }

}
