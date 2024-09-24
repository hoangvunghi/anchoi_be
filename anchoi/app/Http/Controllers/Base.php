<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Base extends Controller
{
    public function contact()
    {
        return view('contact');
    }
}
