<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Blend;
use App\Congthuc;
use App\GLHL;
use App\Xuat;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;




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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $blends = Blend::count();
        $congthucs = Congthuc::count();
        $glhls = GLHL::count();
        
        
        
        return view('home', compact('blends','congthucs','glhls'));
        //return view('home');
    }
}
