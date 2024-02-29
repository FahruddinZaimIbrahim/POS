<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function foodBeverage() {
        return 'Makanan & Minuman';
    }
    public function beautyHealth() {
        return 'Kecantikan';
    }
    public function homeCare() {
        return 'Perawatan Rumah';
    }
    public function babyKid() {
        return 'Bayi';
    }
}
