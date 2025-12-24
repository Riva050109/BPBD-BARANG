<?php

namespace App\Http\Controllers; // <- Pastikan ini benar

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller // <- Nama class harus sama
{
    public function index()
    {
        return view('admin.users.index');
    }
}