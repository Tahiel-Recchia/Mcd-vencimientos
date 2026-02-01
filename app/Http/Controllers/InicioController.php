<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InicioController extends Controller
{
    public function getCategories(){
        $names = null;
    }

    public function index(){
        return view('category');
    }
}
