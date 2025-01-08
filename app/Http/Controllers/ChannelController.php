<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Category;
use App\Services\XtreamService;
use App\Services\EpgService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChannelController extends Controller
{
    protected $xtreamService;
    protected $epgService;

    public function __construct(XtreamService $xtreamService, EpgService $epgService)
    {
        $this->xtreamService = $xtreamService;
        $this->epgService = $epgService;
    }

    public function index(Request $request)
    {
        $query = Channel::with('category')
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('stream_url', 'like', "%{$search}%");
            })
            ->when($request->category, function ($query, $category) {
                $query->where('category_id', $category);
            })
            ->when($request->type, function ($query, $type) {
                $query->where('stream_type', $type);
            })
            ->when($request->status, function ($query, $status) {
                $query->where('is_active', $status === 'active');
            });

        return Inertia::render('Channels/Index', [
            'channels' => $query->paginate(10)->withQueryString(),
            'filters' => $request->only(['search', 'category', 'type', 'status']),
        ]);
    }

    public function create()
    {
        return Inertia::render('Channels/Form', [
            'categories' => Category::all(),
            'epgChannels' => $this->epgService->getChannels(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'stream_url' => 'required|url',
            'logo' => 'nullable|url',
            'category_id' => 'nullable|exists:categories,id',
            'stream_type' => 'required|in:live,movie,series',
            'is_active' => 'boolean',
            'epg_channel_id' => 'nullable|string',
        ]);

        Channel::create($validated);

        return redirect()->route('channels.index')
            ->with('success', 'Channel created successfully.');
    }

    public function edit(Channel $channel)
    {
        return Inertia::render('Channels/Form', [
            'channel' => $channel,
            'categories' => Category::all(),
            'epgChannels' => $this->epgService->getChannels(),
        ]);
    }

    public function update(Request $request, Channel $channel)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'stream_url' => 'required|url',
            'logo' => 'nullable|url',
            'category_id' => 'nullable|exists:categories,id',
            'stream_type' => 'required|in:live,movie,series',
            'is_active' => 'boolean',
            'epg_channel_id' => 'nullable|string',
        ]);

        $channel->update($validated);

        return redirect()->route('channels.index')
            ->with('success', 'Channel updated successfully.');
    }

    public function destroy(Request $request)
    {
        if ($request->ids) {
            Channel::whereIn('id', $request->ids)->delete();
            $message = count($request->ids) . ' channels deleted successfully.';
        } else {
            Channel::findOrFail($request->route('channel'))->delete();
            $message = 'Channel deleted successfully.';
        }

        return redirect()->route('channels.index')
            ->with('success', $message);
    }

    public function refreshEpg()
    {
        $this->epgService->refreshData();

        return response()->json([
            'message' => 'EPG data refreshed successfully.',
        ]);
    }
}
