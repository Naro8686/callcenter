<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Contact extends Model
{
    use Notifiable;

    protected $fillable = ['name', 'phone', 'massage', 'url'];
    protected $casts = ['status' => 'boolean'];

    public function routeNotificationForZadarma($notification)
    {
        return $this->phone;
    }
}
