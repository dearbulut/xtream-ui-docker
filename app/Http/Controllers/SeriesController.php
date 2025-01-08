<?php

namespace App\Http\Controllers;

use App\Models\Series;
use App\Models\Season;
use App\Models\Episode;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SeriesController extends Controller
{
    public function index(Request $request)
    {
        $query = Series::with(['category', 'seasons'])
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

        return Inertia::render('Series/Index', [
            'series' => $query->paginate(12)->withQueryString(),
            'filters' => $request->only(['search', 'category', 'status']),
        ]);
    }

    public function create()
    {
        return Inertia::render('Series/Form', [
            'categories' => Category::where('type', 'series')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|url',
            'category_id' => 'nullable|exists:categories,id',
            'stream_type' => 'required|in:series',
            'is_active' => 'boolean',
            'description' => 'nullable|string',
            'release_date' => 'nullable|date',
            'director' => 'nullable|string',
            'cast' => 'nullable|string',
            'genre' => 'nullable|string',
            'rating' => 'nullable|string',
            'poster' => 'nullable|url',
            'backdrop' => 'nullable|url',
            'trailer_url' => 'nullable|url',
            'seasons' => 'array',
            'seasons.*.name' => 'required|string',
            'seasons.*.season_number' => 'required|integer',
            'seasons.*.description' => 'nullable|string',
            'seasons.*.poster' => 'nullable|url',
            'seasons.*.episodes' => 'array',
            'seasons.*.episodes.*.name' => 'required|string',
            'seasons.*.episodes.*.episode_number' => 'required|integer',
            'seasons.*.episodes.*.stream_url' => 'required|url',
            'seasons.*.episodes.*.description' => 'nullable|string',
            'seasons.*.episodes.*.duration' => 'nullable|string',
            'seasons.*.episodes.*.air_date' => 'nullable|date',
            'seasons.*.episodes.*.poster' => 'nullable|url',
            'seasons.*.episodes.*.subtitles' => 'array',
            'seasons.*.episodes.*.audio_tracks' => 'array',
        ]);

        $series = Series::create($validated);

        foreach ($validated['seasons'] ?? [] as $seasonData) {
            $episodes = $seasonData['episodes'] ?? [];
            unset($seasonData['episodes']);

            $season = $series->seasons()->create($seasonData);

            foreach ($episodes as $episodeData) {
                $season->episodes()->create($episodeData);
            }
        }

        return redirect()->route('series.index')
            ->with('success', 'Series created successfully.');
    }

    public function show(Series $series)
    {
        return Inertia::render('Series/Show', [
            'series' => $series->load(['category', 'seasons.episodes']),
        ]);
    }

    public function edit(Series $series)
    {
        return Inertia::render('Series/Form', [
            'series' => $series->load(['seasons.episodes']),
            'categories' => Category::where('type', 'series')->get(),
        ]);
    }

    public function update(Request $request, Series $series)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|url',
            'category_id' => 'nullable|exists:categories,id',
            'stream_type' => 'required|in:series',
            'is_active' => 'boolean',
            'description' => 'nullable|string',
            'release_date' => 'nullable|date',
            'director' => 'nullable|string',
            'cast' => 'nullable|string',
            'genre' => 'nullable|string',
            'rating' => 'nullable|string',
            'poster' => 'nullable|url',
            'backdrop' => 'nullable|url',
            'trailer_url' => 'nullable|url',
            'seasons' => 'array',
            'seasons.*.name' => 'required|string',
            'seasons.*.season_number' => 'required|integer',
            'seasons.*.description' => 'nullable|string',
            'seasons.*.poster' => 'nullable|url',
            'seasons.*.episodes' => 'array',
            'seasons.*.episodes.*.name' => 'required|string',
            'seasons.*.episodes.*.episode_number' => 'required|integer',
            'seasons.*.episodes.*.stream_url' => 'required|url',
            'seasons.*.episodes.*.description' => 'nullable|string',
            'seasons.*.episodes.*.duration' => 'nullable|string',
            'seasons.*.episodes.*.air_date' => 'nullable|date',
            'seasons.*.episodes.*.poster' => 'nullable|url',
            'seasons.*.episodes.*.subtitles' => 'array',
            'seasons.*.episodes.*.audio_tracks' => 'array',
        ]);

        $series->update($validated);

        // Mevcut sezonları ve bölümleri sil
        $series->seasons()->delete();

        // Yeni sezonları ve bölümleri ekle
        foreach ($validated['seasons'] ?? [] as $seasonData) {
            $episodes = $seasonData['episodes'] ?? [];
            unset($seasonData['episodes']);

            $season = $series->seasons()->create($seasonData);

            foreach ($episodes as $episodeData) {
                $season->episodes()->create($episodeData);
            }
        }

        return redirect()->route('series.index')
            ->with('success', 'Series updated successfully.');
    }

    public function destroy(Request $request)
    {
        if ($request->ids) {
            Series::whereIn('id', $request->ids)->delete();
            $message = count($request->ids) . ' series deleted successfully.';
        } else {
            Series::findOrFail($request->route('series'))->delete();
            $message = 'Series deleted successfully.';
        }

        return redirect()->route('series.index')
            ->with('success', $message);
    }
}
