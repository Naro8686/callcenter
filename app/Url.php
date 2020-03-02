<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    protected $fillable = ['domain'];
    public $timestamps = false;

    public function seo()
    {
        return $this->hasOne(Seo::class);
    }
}
