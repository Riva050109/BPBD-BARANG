<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BAPenyerahanController extends Controller
{
    public function index()
    {
        return view('ba-penyerahan.index');
    }
}
