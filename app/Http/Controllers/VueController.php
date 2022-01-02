<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VueController extends Controller
{
    public function index()
    {
        return view('vue.index');
    }

    public function post(Request $request)
    {
        dd($request->all());
    }
}
