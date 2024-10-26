<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\User;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('profile');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'url' => 'required|url|max:2048'
        ]);

        $link = $request->user()->links()->create($validated);

        return back()->with('success', 'Link created successfully!');
    }
public function destroy(Link $link)
{
    // Ensure the user owns this link
    if ($link->user_id !== auth()->id()) {
        return response()->json(['message' => 'Unauthorized'], 403);
    }

    try {
        $link->delete();
        return response()->json(['message' => 'Link deleted successfully']);
    } catch (\Exception $e) {
        \Log::error('Error deleting link: ' . $e->getMessage());
        return response()->json(['message' => 'Error deleting link'], 500);
    }
}

public function update(Request $request, Link $link)
{
    echo $link;
    // Ensure the user owns this link
    if ($link->user_id !== auth()->id()) {
        return response()->json(['message' => 'Unauthorized'], 403);
    }

    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'url' => 'required|url|max:255',
    ]);

    try {
        $link->update($validated);
        return response()->json(['message' => 'Link updated successfully']);
    } catch (\Exception $e) {
        \Log::error('Error updating link: ' . $e->getMessage());
        return response()->json(['message' => 'Error updating link'], 500);
    }
}


public function profile($username)
{
    // Find the user by username instead of name
    $user = User::where('username', $username)->firstOrFail();
    
    // Get the user's links
    $links = $user->links()
        ->orderBy('created_at', 'desc')
        ->get();

    return view("public.profile", [
        'user' => $user,
        'links' => $links
    ]);
}

}


