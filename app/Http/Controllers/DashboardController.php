<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Quote;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'products' => Product::count(),
            'active_products' => Product::where('is_active', true)->count(),
            'categories' => Category::where('is_active', true)->count(),
            'quotes' => Quote::count(),
            'pending_quotes' => Quote::where('status', 'pending')->count(),
        ];

        $recentQuotes = Quote::with('product')
            ->latest()
            ->limit(5)
            ->get();

        $recentProducts = Product::with(['category', 'images'])
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard.index', compact('stats', 'recentQuotes', 'recentProducts'));
    }
}

