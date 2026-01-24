<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Link;

class HomeController extends Controller
{
    public function index()
    {
        $links = auth()->user()
            ->links()
            ->where('status', true)
            ->orderBy('position')
            ->get();

        return view('index', compact('links'));
    }
}
