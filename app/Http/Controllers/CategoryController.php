<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::query()
            ->where('is_active', true)
            ->orderBy('order')
            ->withCount('activeProducts')
            ->get();

        return view('categories.index', compact('categories'));
    }

    public function show(string $slug): View
    {
        $category = Category::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $products = $category->activeProducts()
            ->with(['images', 'category', 'tags', 'materials'])
            ->paginate(12);

        return view('categories.show', compact('category', 'products'));
    }
}
