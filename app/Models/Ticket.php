<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id',
        'description',
        'closed_at',
        'created_at',
        'id_ticket',
        'image_link'
    ];

    protected $with = ['proces', 'device'];

    public function device()
    {
        return $this->belongsTo(\App\Models\Device::class, 'device_id');
    }

    public function proces()
    {
        return $this->hasOne(\App\Models\Proces::class);
    }
}
