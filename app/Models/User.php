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
        'firstname',
        'lastname',
        'pronoun',
        'used_agreements',
        'gender',
        'title',
        'environment',
        'birthdate',
        'years_xp',
        'work_city',
        'work_phone',
        'description',
        'audience',
        'interests',
        'hear_about',
        'newsletter',
        'notifications',
        'conditions',
        'email',
        'password',
        'notifs_check',
        'verified',
        'image_id',
        'ban',
        'approved_email',
        'refused_email',
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

    public function chatbotMessages()
    {
        return $this->hasMany(ChatbotMessage::class, 'sender');
    }

    public function conversationBookmarks()
    {
        return $this->hasMany('App\Models\ConversationBookmarks');
    }

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

    public function replyLikes()
    {
        return $this->hasMany('App\Models\ReplyLike');
    }

    public function conversationLikes()
    {
        return $this->hasMany('App\Models\ConversationLike');
    }
    
    public function postmarks()
    {
        return $this->hasMany(Postmark::class);
    }

    public function signets()
    {
        return $this->hasMany(Signet::class);
    }

    public function bookmarksThematiques()
    {
        return $this->hasMany(BookmarkThematiques::class);
    }

    public function media(){
        return $this->hasMany(Media::class);
    }

    public function files()
    {
        return $this->hasMany('App\Models\File');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Models\Role');
    }

    public function messages()
    {
        return $this->belongsToMany('App\Models\Message');
    }

    public function reportedBy()
    {
        return $this->hasMany('App\Models\Signalement', 'reported_user_user_id');
    }

    public function reports()
    {
        return $this->hasMany('App\Models\Signalement', 'reported_author_user_id');
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

    public function profilePicture()
    {
        return $this->belongsTo(Media::class, 'image_id');
    }
    public function followers()
    {
        return $this->belongsToMany(User::class, 'user_followings', 'following_id', 'follower_id');
    }

    public function following()
    {
        return $this->belongsToMany(User::class, 'user_followings', 'follower_id', 'following_id');
    }
}
