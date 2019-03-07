<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = [
        'post_id', 'url',
    ];

    public function posts()
    {
        return $this->belongsTo('App\Post');
    }
}
