<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news';
    protected $guarded = [];

    public function media()
    {
        return $this->hasMany(MediaNews::class);
    }
}
