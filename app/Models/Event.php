<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'desc',
        'address',
        'link',
        'image_id',
        'start_at',
    ];

    public function image()
    {
        return $this->belongsTo(Media::class, 'image_id');
    }
}
