<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Accounting;
use App\Customer;


class AccountingController extends Controller
{


	public function index()
    {
    	$accounting = Accounting::all();
       

    	return view('bowner.accounting.index', compact('accounting'));
    }

    public function createPayment()
    {
    	$customers = Customer::all();
    	return view('bowner.accounting.entry', compact('customers'));
   
    }
    public function storePayment(){
    	
    }
}
