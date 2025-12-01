<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => ['nullable', 'exists:products,id'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'quantity' => ['required', 'integer', 'min:1'],
            'artwork_file' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,ai,psd,cdr', 'max:10240'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Por favor, informe seu nome.',
            'email.required' => 'Por favor, informe seu e-mail.',
            'email.email' => 'Por favor, informe um e-mail válido.',
            'phone.required' => 'Por favor, informe seu telefone.',
            'quantity.required' => 'Por favor, informe a quantidade desejada.',
            'quantity.min' => 'A quantidade mínima é 1.',
            'artwork_file.mimes' => 'O arquivo deve ser PDF, JPG, PNG, AI, PSD ou CDR.',
            'artwork_file.max' => 'O arquivo não pode ser maior que 10MB.',
        ];
    }
}
