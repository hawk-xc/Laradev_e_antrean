<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function proces()
    {
        return $this->hasOne(\App\Models\Proces::class);
    }
}
