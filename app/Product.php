<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //

    public function unit()
    {
    	return $this->belongsTo('App\Unit');
    }

    public function warehouse()
    {
    	return $this->belongsTo('App\Warehouses');
    }

    public function material()
    {
    	return $this->belongsTo('App\Material');
    }

     public function supplier()
    {
    	return $this->belongsTo('App\Supplier');
    }
     public function bom()
    {
        return $this->belongsTo('App\Bom');
    }
}
