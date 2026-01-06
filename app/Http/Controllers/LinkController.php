<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Link;
use App\Services\SlugService;

class LinkController extends Controller
{
    public function index(): View
    {
        return view('links.create');
    }

    public function store(Request $request, SlugService $slugService)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'url'  => ['required', 'url', 'max:250'],
        ]);

        $userId = $request->user()->id;

        $slug = $slugService->generateForUserLink($userId, $data['name']);

        $lastPosition = Link::where('user_id', $userId)
            ->where('status', true)
            ->max('position');

        $position = ($lastPosition ?? 0) + 1;

        Link::create([
            'user_id' => $userId,
            'name' => $data['name'],
            'url' => $data['url'],
            'position' => $position,
            'status' => true,
            'slug'=> $slug,
        ]);

        return redirect()->route('index')->with('status', 'Link created successfully!');
    }
}
