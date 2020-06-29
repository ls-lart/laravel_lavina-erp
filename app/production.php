<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class production extends Model
{
    public function product() {
        return $this->belongsTo('App\Product');    
    }
    public function material() {
        return $this->belongsTo('App\Material');    
    }
}
