<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function toggle(Request $request, Product $product): JsonResponse
    {
        if (! Auth::check()) {
            return response()->json(['error' => 'Usuário não autenticado'], 401);
        }

        $favorite = Favorite::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($favorite) {
            $favorite->delete();

            return response()->json([
                'favorited' => false,
                'message' => 'Produto removido dos favoritos',
                'product_id' => $product->id,
            ]);
        } else {
            Favorite::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
            ]);

            return response()->json([
                'favorited' => true,
                'message' => 'Produto adicionado aos favoritos',
                'product_id' => $product->id,
            ]);
        }
    }

    public function destroy(Product $product): JsonResponse
    {
        if (! Auth::check()) {
            return response()->json(['error' => 'Usuário não autenticado'], 401);
        }

        $favorite = Favorite::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($favorite) {
            $favorite->delete();

            return response()->json([
                'success' => true,
                'message' => 'Produto removido dos favoritos',
                'product_id' => $product->id,
            ]);
        }

        return response()->json(['error' => 'Favorito não encontrado'], 404);
    }

    public function index()
    {
        $favorites = Auth::user()->favoriteProducts()
            ->with(['category', 'images'])
            ->paginate(12);

        return view('favorites.index', compact('favorites'));
    }

    public function check(Product $product): JsonResponse
    {
        if (! Auth::check()) {
            return response()->json(['favorited' => false]);
        }

        $favorited = Favorite::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->exists();

        return response()->json(['favorited' => $favorited]);
    }

    public function list(): JsonResponse
    {
        if (! Auth::check()) {
            return response()->json(['favorites' => []]);
        }

        try {
            $favorites = Favorite::where('user_id', Auth::id())
                ->pluck('product_id')
                ->toArray();

            return response()->json(['favorites' => $favorites]);
        } catch (\Exception $e) {
            \Log::error('Erro ao listar favoritos: '.$e->getMessage());

            return response()->json(['favorites' => [], 'error' => 'Erro ao carregar favoritos'], 500);
        }
    }
}
