<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = ['name', 'phone', 'massage', 'url'];
    protected $casts = ['status' => 'boolean'];
}
