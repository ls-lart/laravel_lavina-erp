<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class StockLog extends Model
{
	public function supplier()
    {
    	return $this->belongsTo('App\Supplier');
    }
    public function product() {
        return $this->belongsTo('App\Product');    
    } 
    public function purchase() {
        return $this->belongsTo('App\Purchase');    
    } 
    public function customer() {
        return $this->belongsTo('App\Customer');    
    } 
	
}