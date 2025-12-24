<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MasterDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('master-data.index');
    }
}