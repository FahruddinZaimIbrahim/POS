<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function welcome() {
        return 'Welcome';
    }
    public function about() {
        return '2241720253_FahruddinZaimIbrahim';
    }
    public function articles($articlesId) {
            return 'Article Page With id '.$articlesId;
    }
}
