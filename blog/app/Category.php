<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //le categorie possono avere piu posts 
    // category posts

    public function posts()
    {
        return $this->hasMany('App\Post'); // category ha tanti posts
    }
}
