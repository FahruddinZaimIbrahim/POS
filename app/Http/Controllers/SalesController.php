<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index(){
        return view('sales')
        ->with('jumlahPenjualan','100')
        ->with('income','5 Billion');
        ;
    }
}
