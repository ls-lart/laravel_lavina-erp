<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WipProduction extends Model
{
   public function product() {
        return $this->belongsTo('App\Product');    
    }  
     public function shift() {
        return $this->belongsTo('App\ShiftLog');    
    }  

}
