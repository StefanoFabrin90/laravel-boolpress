<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'category_id',
    ];

    //relazione posts categories (i posts posso avere solo una categoria)
    public function category()
    {
        return $this->belongsTo('App\Category'); // posts appartiene a category
    }


    //relazioni con tags
    //posts - tags
    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }
}
