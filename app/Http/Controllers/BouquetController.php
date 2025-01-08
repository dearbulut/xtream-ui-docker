<?php

namespace App\Http\Controllers;

use App\Models\Bouquet;
use App\Models\Channel;
use App\Models\Movie;
use App\Models\Series;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BouquetController extends Controller
{
    public function index(Request $request)
    {
        $query = Bouquet::with(['channels', 'movies', 'series'])
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            })
            ->when($request->type, function ($query, $type) {
                $query->where('type', $type);
            })
            ->when($request->status, function ($query, $status) {
                $query->where('is_active', $status === 'active');
            });

        return Inertia::render('Bouquets/Index', [
            'bouquets' => $query->paginate(10)->withQueryString(),
            'filters' => $request->only(['search', 'type', 'status']),
        ]);
    }

    public function create()
    {
        return Inertia::render('Bouquets/Form', [
            'channels' => Channel::all(),
            'movies' => Movie::all(),
            'series' => Series::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:all,channel,movie,series',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
            'channels' => 'array',
            'movies' => 'array',
            'series' => 'array',
        ]);

        $bouquet = Bouquet::create($validated);

        if ($request->channels) {
            $bouquet->channels()->attach($request->channels);
        }

        if ($request->movies) {
            $bouquet->movies()->attach($request->movies);
        }

        if ($request->series) {
            $bouquet->series()->attach($request->series);
        }

        return redirect()->route('bouquets.index')
            ->with('success', 'Bouquet created successfully.');
    }

    public function show(Bouquet $bouquet)
    {
        return Inertia::render('Bouquets/Show', [
            'bouquet' => $bouquet->load(['channels.category', 'movies', 'series']),
        ]);
    }

    public function edit(Bouquet $bouquet)
    {
        return Inertia::render('Bouquets/Form', [
            'bouquet' => $bouquet->load(['channels', 'movies', 'series']),
            'channels' => Channel::all(),
            'movies' => Movie::all(),
            'series' => Series::all(),
        ]);
    }

    public function update(Request $request, Bouquet $bouquet)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:all,channel,movie,series',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
            'channels' => 'array',
            'movies' => 'array',
            'series' => 'array',
        ]);

        $bouquet->update($validated);

        $bouquet->channels()->sync($request->channels);
        $bouquet->movies()->sync($request->movies);
        $bouquet->series()->sync($request->series);

        return redirect()->route('bouquets.index')
            ->with('success', 'Bouquet updated successfully.');
    }

    public function destroy(Request $request)
    {
        if ($request->ids) {
            Bouquet::whereIn('id', $request->ids)->delete();
            $message = count($request->ids) . ' bouquets deleted successfully.';
        } else {
            Bouquet::findOrFail($request->route('bouquet'))->delete();
            $message = 'Bouquet deleted successfully.';
        }

        return redirect()->route('bouquets.index')
            ->with('success', $message);
    }
}
