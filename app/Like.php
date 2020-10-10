<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    public function news()
    {
        return $this->belongsTo(News::class, 'news_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
