<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVenueRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'name'        => 'required|string|max:255',
            'address'     => 'required|string|max:255',
            'city'        => 'required|string|max:100',
            'description' => 'nullable|string',
            'phone'       => 'nullable|string|max:20',
            'active'      => 'boolean',
            'image'       => 'nullable|image|max:2048',
        ];
    }
}