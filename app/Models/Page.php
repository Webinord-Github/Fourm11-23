<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Page extends Model
{
    use HasFactory;



    protected $fillable = [
        'title',
        'url',
        'content',
        'user_id',
        'categorie',
        'order',
        'parent_id',
    ];
    
    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function parent()
    {
        return $this->belongsTo('App\Models\Page', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('App\Models\Page', 'parent_id');
    }
}


