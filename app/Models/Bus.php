<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bus extends Model {
    protected $table = 'buses';
    
    public function routes() {
        return $this->hasMany(Route::class);
    }
}