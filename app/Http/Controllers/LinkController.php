<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class LinkController extends Controller
{
    public function index(): View
    {
        return view('links.create');
    }

    public function store(Request $request)
    {
        dd($request->all());

        return redirect()->route('links.create')->with('status', 'Link created successfully!');
    }
}
