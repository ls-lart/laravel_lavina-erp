<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Scraps extends Model
{

	public function shift()
    {
    	return $this->belongsTo('App\ShiftLog');
    }

}