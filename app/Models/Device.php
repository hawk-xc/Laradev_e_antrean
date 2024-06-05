<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'device_name',
        'device_year',
        'drive_link',
        'image_link'
    ];

    // protected $with = ['user', 'ticket'];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function ticket()
    {
        return $this->hasMany(\App\Models\Ticket::class);
    }
}
