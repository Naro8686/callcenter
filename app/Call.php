<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Call extends Model
{
    protected $fillable = ['name', 'phone', 'status'];
    protected $casts = ['status' => 'boolean'];
}
