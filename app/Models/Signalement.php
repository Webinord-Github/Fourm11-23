<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Signalement extends Model
{
    use HasFactory;
    protected $fillable = [
        'reported_author_user_id',
        'reported_user_user_id',
        'report',
        'fixed'
    ];
}
