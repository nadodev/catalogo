<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class QuoteController extends Controller
{
    public function index(Request $request): View
    {
        $query = Quote::with('product')->latest();

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $quotes = $query->paginate(15);

        return view('admin.quotes.index', compact('quotes'));
    }

    public function show(Quote $quote): View
    {
        $quote->load('product');
        return view('admin.quotes.show', compact('quote'));
    }

    public function updateStatus(Request $request, Quote $quote): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,processed,cancelled'],
        ]);

        $quote->update($validated);

        return back()->with('success', 'Status do orçamento atualizado com sucesso!');
    }

    public function destroy(Quote $quote): RedirectResponse
    {
        if ($quote->artwork_file) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($quote->artwork_file);
        }

        $quote->delete();

        return redirect()->route('admin.quotes.index')->with('success', 'Orçamento excluído com sucesso!');
    }
}

