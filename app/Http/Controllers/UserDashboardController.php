<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserDashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        $stats = [
            'favorites_count' => $user->favorites()->count(),
            'quotes_count' => Quote::where('email', $user->email)->count(),
            'pending_quotes' => Quote::where('email', $user->email)->where('status', 'pending')->count(),
        ];

        return view('user.dashboard', compact('stats'));
    }

    public function profile(): View
    {
        $user = Auth::user();

        return view('user.profile', compact('user'));
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (! empty($validated['password'])) {
            $user->password = \Illuminate\Support\Facades\Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('user.profile')->with('success', 'Perfil atualizado com sucesso!');
    }

    public function orders(): View
    {
        $user = Auth::user();
        $quotes = Quote::where('email', $user->email)
            ->with('product')
            ->latest()
            ->paginate(10);

        return view('user.orders', compact('quotes'));
    }

    public function favorites(): View
    {
        $user = Auth::user();
        $favorites = $user->favoriteProducts()
            ->with(['category', 'images'])
            ->paginate(12);

        return view('user.favorites', compact('favorites'));
    }
}
