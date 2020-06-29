<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubMachines extends Model
{
    //
    public function machine()
    {
    	return $this->belongsTo('App\Machines');
    }

    public function breakdowns()
    {
    	return $this->belongsTo('App\MachineBreakdowns');
    }
}
