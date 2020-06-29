<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShiftLog extends Model
{
    public function human()
    {
    	return $this->belongsTo('App\Human');
    }
}
