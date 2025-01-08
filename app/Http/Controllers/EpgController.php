<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\EpgProgram;
use App\Services\EpgService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EpgController extends Controller
{
    protected $epgService;

    public function __construct(EpgService $epgService)
    {
        $this->epgService = $epgService;
    }

    public function index(Request $request)
    {
        $query = Channel::with(['category', 'epgPrograms' => function ($query) use ($request) {
            $query->whereDate('start_time', $request->date ?? now())
                ->orderBy('start_time');
        }])
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->when($request->category, function ($query, $category) {
                $query->where('category_id', $category);
            });

        return Inertia::render('Epg/Index', [
            'channels' => $query->paginate(10)->withQueryString(),
            'filters' => $request->only(['search', 'category', 'date']),
        ]);
    }

    public function refresh()
    {
        $this->epgService->refreshData();

        return redirect()->back()
            ->with('success', 'EPG data refreshed successfully.');
    }

    public function show(Channel $channel, Request $request)
    {
        $programs = EpgProgram::where('channel_id', $channel->id)
            ->whereDate('start_time', $request->date ?? now())
            ->orderBy('start_time')
            ->get();

        return Inertia::render('Epg/Show', [
            'channel' => $channel->load('category'),
            'programs' => $programs,
            'date' => $request->date ?? now()->toDateString(),
        ]);
    }

    public function update(Channel $channel, Request $request)
    {
        $validated = $request->validate([
            'epg_channel_id' => 'nullable|string',
        ]);

        $channel->update($validated);

        return redirect()->back()
            ->with('success', 'EPG channel ID updated successfully.');
    }
}
