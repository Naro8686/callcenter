<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
    protected $fillable = ['title', 'keywords', 'description', 'text','url_id'];

    public function url()
    {
        return $this->belongsTo(Url::class);
    }
}
