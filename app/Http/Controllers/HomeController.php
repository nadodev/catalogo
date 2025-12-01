<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = \App\Models\Product::query()
            ->with(['category', 'images'])
            ->active()
            ->featured()
            ->limit(8)
            ->get();

        // Buscar produto em destaque para a hero (com imagem)
        $heroProduct = \App\Models\Product::query()
            ->with(['images'])
            ->where('is_active', true)
            ->whereHas('images')
            ->where(function ($query) {
                $query->where('is_featured', true)
                    ->orWhere('is_popular', true);
            })
            ->first();

        // Se não encontrar, busca qualquer produto com imagem
        if (! $heroProduct) {
            $heroProduct = \App\Models\Product::query()
                ->with(['images'])
                ->where('is_active', true)
                ->whereHas('images')
                ->first();
        }

        $categories = \App\Models\Category::query()
            ->where('is_active', true)
            ->orderBy('order')
            ->get();

        return view('pages.home', compact('featuredProducts', 'categories', 'heroProduct'));
    }
}
