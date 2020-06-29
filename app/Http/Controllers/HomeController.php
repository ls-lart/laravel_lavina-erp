<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check()) {

    if (Auth::user()->isBowner()) {
        return redirect('/bowner');
    }elseif (Auth::user()->isManager()) {
        return redirect('/manager');
    } elseif (Auth::user()->isAdmin()) {
        return redirect('/admin');
    } elseif (Auth::user()->isEmployee()) {
            // check user access 
            if(Auth::user()->access == 'production'){
                return redirect('/bowner/production');
            }else{
                 return view('home');
            }
      
    }elseif (Auth::user()->isProduction()) {
        return redirect('/bowner');
    }elseif (Auth::user()->isShiftLeader()) {
        return redirect('/bowner');
    } else {
        return view('home');
    } 

    } 
    }
}
