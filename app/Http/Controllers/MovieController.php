<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        $query = Movie::with('category')
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            })
            ->when($request->category, function ($query, $category) {
                $query->where('category_id', $category);
            })
            ->when($request->status, function ($query, $status) {
                $query->where('is_active', $status === 'active');
            });

        return Inertia::render('Movies/Index', [
            'movies' => $query->paginate(12)->withQueryString(),
            'filters' => $request->only(['search', 'category', 'status']),
        ]);
    }

    public function create()
    {
        return Inertia::render('Movies/Form', [
            'categories' => Category::where('type', 'movie')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'stream_url' => 'required|url',
            'logo' => 'nullable|url',
            'category_id' => 'nullable|exists:categories,id',
            'stream_type' => 'required|in:movie',
            'is_active' => 'boolean',
            'description' => 'nullable|string',
            'duration' => 'nullable|string',
            'release_date' => 'nullable|date',
            'director' => 'nullable|string',
            'cast' => 'nullable|string',
            'genre' => 'nullable|string',
            'rating' => 'nullable|string',
            'poster' => 'nullable|url',
            'backdrop' => 'nullable|url',
            'trailer_url' => 'nullable|url',
            'subtitles' => 'array',
            'audio_tracks' => 'array',
        ]);

        Movie::create($validated);

        return redirect()->route('movies.index')
            ->with('success', 'Movie created successfully.');
    }

    public function show(Movie $movie)
    {
        return Inertia::render('Movies/Show', [
            'movie' => $movie->load('category'),
        ]);
    }

    public function edit(Movie $movie)
    {
        return Inertia::render('Movies/Form', [
            'movie' => $movie,
            'categories' => Category::where('type', 'movie')->get(),
        ]);
    }

    public function update(Request $request, Movie $movie)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'stream_url' => 'required|url',
            'logo' => 'nullable|url',
            'category_id' => 'nullable|exists:categories,id',
            'stream_type' => 'required|in:movie',
            'is_active' => 'boolean',
            'description' => 'nullable|string',
            'duration' => 'nullable|string',
            'release_date' => 'nullable|date',
            'director' => 'nullable|string',
            'cast' => 'nullable|string',
            'genre' => 'nullable|string',
            'rating' => 'nullable|string',
            'poster' => 'nullable|url',
            'backdrop' => 'nullable|url',
            'trailer_url' => 'nullable|url',
            'subtitles' => 'array',
            'audio_tracks' => 'array',
        ]);

        $movie->update($validated);

        return redirect()->route('movies.index')
            ->with('success', 'Movie updated successfully.');
    }

    public function destroy(Request $request)
    {
        if ($request->ids) {
            Movie::whereIn('id', $request->ids)->delete();
            $message = count($request->ids) . ' movies deleted successfully.';
        } else {
            Movie::findOrFail($request->route('movie'))->delete();
            $message = 'Movie deleted successfully.';
        }

        return redirect()->route('movies.index')
            ->with('success', $message);
    }
}
