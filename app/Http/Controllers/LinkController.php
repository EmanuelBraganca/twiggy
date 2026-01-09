<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Link;
use App\Services\SlugService;

class LinkController extends Controller
{
    public function index()
    {
        return redirect()->route('links.create');
    }

    public function create(): View
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

    public function edit(Link $link)
    {
        return view('links.edit', compact('link'));
    }

    public function update(Request $request, Link $link, SlugService $slugService)
    {
        if ($link->user_id !== $request->user()->id) {
            abort(403);
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'url'  => ['required', 'url', 'max:250'],
        ]);

        $slug = $slugService->generateForUserLink($request->user()->id, $data['name']);

        $link->update([
            'name' => $data['name'],
            'url' => $data['url'],
            'slug' => $slug,
        ]);

        return redirect()->route('index')->with('status', 'Link updated successfully!');
    }

    public function destroy(Request $request, Link $link)
    {
        if ($link->user_id !== $request->user()->id) {
            abort(403);
        }

        $link->delete();

        return redirect()->route('index')->with('status', 'Link deleted successfully!');
    }
}
