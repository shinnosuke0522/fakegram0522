<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = [
        'u_id', 'post_id',
    ];

    public function post()
    {
        return $this->belongsTo('App\Post', 'post_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'u_id');
    }
}
