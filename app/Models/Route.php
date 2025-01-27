<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Route extends Model {
    protected $table = 'routes';
    
    public function bus() {
        return $this->belongsTo(Bus::class);
    }

    public function routeStops() {
        return $this->hasMany(RouteStop::class);
    }
}
