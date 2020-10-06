<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class NewsByCategory extends Model
{
    use Sluggable;

    public function news()
    {
        return $this->hasMany(News::class, 'category_id', 'id');
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
