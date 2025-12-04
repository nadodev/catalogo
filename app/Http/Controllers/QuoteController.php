<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Models\Product;
use App\Http\Requests\StoreQuoteRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;

class QuoteController extends Controller
{
    public function create(?string $productSlug = null): View
    {
        $product = null;

        if ($productSlug) {
            $product = Product::query()
                ->where('slug', $productSlug)
                ->active()
                ->firstOrFail();
        }

        return view('quotes.create', compact('product'));
    }

    public function store(StoreQuoteRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['ip_address'] = $request->ip();

        // Handle file upload
        if ($request->hasFile('artwork_file')) {
            $file = $request->file('artwork_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('quotes', $filename, 'public');
            $data['artwork_file'] = $path;
        }

        Quote::create($data);

        return redirect()->back()->with('success', 'Orçamento enviado com sucesso! Entraremos em contato em breve.');
    }

    public function storeFromCart(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'cart_items' => ['required', 'string'],
            'contact_method' => ['nullable', 'string', 'in:email,whatsapp'],
        ]);

        $cartItems = json_decode($request->cart_items, true);

        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Seu carrinho está vazio!');
        }

        // Calcular total do pedido
        $totalItems = 0;
        $totalValue = 0;
        foreach ($cartItems as $item) {
            $totalItems += $item['quantity'] ?? 1;
            if (isset($item['price']) && $item['price'] > 0) {
                $totalValue += ($item['price'] * ($item['quantity'] ?? 1));
            }
        }

        // Criar um orçamento para cada item do carrinho
        foreach ($cartItems as $item) {
            Quote::create([
                'product_id' => $item['id'] ?? null,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'quantity' => $item['quantity'] ?? 1,
                'notes' => ($request->notes ? $request->notes . "\n\n" : '') . "Método de contato: " . ($request->contact_method ?? 'email') . "\n\nProdutos do carrinho:\n" . json_encode($cartItems, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
                'status' => 'pending',
                'ip_address' => $request->ip(),
            ]);
        }

        // Salvar dados do pedido na sessão para exibir na página de confirmação
        $orderData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'items' => $cartItems,
            'total_items' => $totalItems,
            'total_value' => $totalValue,
            'notes' => $request->notes,
            'contact_method' => $request->contact_method ?? 'email',
            'created_at' => now()->format('d/m/Y H:i'),
        ];
        
        session(['order_confirmation' => $orderData]);

        // Aqui você pode enviar um e-mail com todos os produtos
        // Mail::to($request->email)->send(new QuoteConfirmation($cartItems, $request->all()));

        return redirect()->route('cart.confirmation');
    }

    public function confirmation(): \Illuminate\View\View
    {
        $orderData = session('order_confirmation');
        
        if (!$orderData) {
            return redirect()->route('cart.index')->with('error', 'Nenhum pedido encontrado.');
        }

        // Limpar dados da sessão após exibir
        session()->forget('order_confirmation');

        return view('cart.confirmation', compact('orderData'));
    }
}
