<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::with('parent')
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            })
            ->when($request->type, function ($query, $type) {
                $query->where('type', $type);
            })
            ->when($request->parent, function ($query, $parent) {
                $query->where('parent_id', $parent);
            })
            ->when($request->status, function ($query, $status) {
                $query->where('is_active', $status === 'active');
            });

        return Inertia::render('Categories/Index', [
            'categories' => $query->paginate(10)->withQueryString(),
            'filters' => $request->only(['search', 'type', 'parent', 'status']),
        ]);
    }

    public function create()
    {
        return Inertia::render('Categories/Form', [
            'parents' => Category::whereNull('parent_id')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:channel,movie,series',
            'parent_id' => 'nullable|exists:categories,id',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($request->name);

        Category::create($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        return Inertia::render('Categories/Form', [
            'category' => $category,
            'parents' => Category::whereNull('parent_id')
                ->where('id', '!=', $category->id)
                ->get(),
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:channel,movie,series',
            'parent_id' => 'nullable|exists:categories,id',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($request->name);

        $category->update($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(Request $request)
    {
        if ($request->ids) {
            Category::whereIn('id', $request->ids)->delete();
            $message = count($request->ids) . ' categories deleted successfully.';
        } else {
            Category::findOrFail($request->route('category'))->delete();
            $message = 'Category deleted successfully.';
        }

        return redirect()->route('categories.index')
            ->with('success', $message);
    }
}
