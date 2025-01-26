<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    public function bus()
    {
        return $this->belongsTo(Bus::class); // Связь многие-к-одному с автобусом
    }

    public function stops()
    {
        return $this->belongsToMany(Stop::class); // Связь многие-ко-многим с остановками
    }
}
