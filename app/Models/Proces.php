<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proces extends Model
{
    use HasFactory;

    protected $fillable = [
        'status_id',
        'ticket_id',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function status()
    {
        return $this->belongsTo(\App\Models\Status::class, 'status_id');
    }

    public function ticket()
    {
        return $this->belongsTo(\App\Models\Ticket::class, 'ticket_id');
    }
}
