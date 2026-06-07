<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFieldRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'venue_id'       => 'required|exists:venues,id',
            'sport_type_id'  => 'required|exists:sport_types,id',
            'name'           => 'required|string|max:255',
            'description'    => 'nullable|string',
            'price_per_hour' => 'required|numeric|min:0',
            'capacity'       => 'nullable|integer|min:1',
            'surface'        => 'required|in:grass,synthetic,cement',
            'active'         => 'boolean',
        ];
    }
}