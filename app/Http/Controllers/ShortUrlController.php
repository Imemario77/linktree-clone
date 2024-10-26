<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ShortUrlController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('redirect');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'original_url' => 'required|url|max:2048'
        ]);

        // Generate a unique short code
        do {
            $shortCode = Str::random(6);
        } while (ShortUrl::where('short_code', $shortCode)->exists());

        $shortUrl = $request->user()->shortUrls()->create([
            'original_url' => $validated['original_url'],
            'short_code' => $shortCode
        ]);

        return back()->with('success', 'URL shortened successfully!');
    }

    public function redirect($shortCode)
    {
        $shortUrl = ShortUrl::where('short_code', $shortCode)->firstOrFail();
        
        // Increment the click count
        $shortUrl->increment('clicks');

        return redirect($shortUrl->original_url);
    }
public function destroy(ShortUrl $shortUrl)
{
    // Ensure the user owns this short URL
    if ($shortUrl->user_id !== auth()->id()) {
        return response()->json(['message' => 'Unauthorized'], 403);
    }

    try {
        $shortUrl->delete();
        return response()->json(['message' => 'Short URL deleted successfully']);
    } catch (\Exception $e) {
        \Log::error('Error deleting short URL: ' . $e->getMessage());
        return response()->json(['message' => 'Error deleting short URL'], 500);
    }
}
}