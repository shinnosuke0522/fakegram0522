<?php

namespace App;

use Auth;
use App\like;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    protected $fillable = [
        'u_id', 'comment',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'u_id');
    }

    public function photos()
    {
        return $this->hasMany('App\Photo');
    }
    public function likes()
    {
        return $this->hasMany('App\Like');
    }
}
 