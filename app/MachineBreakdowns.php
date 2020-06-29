<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MachineBreakdowns extends Model
{
 	
 	public function subMachine()
    {
    	return $this->belongsTo('App\SubMachines');
    }   
}
