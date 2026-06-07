<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'date'       => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time'   => 'required|date_format:H:i|after:start_time',
            'notes'      => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'date.after_or_equal' => 'La fecha no puede ser en el pasado.',
            'end_time.after'      => 'La hora de fin debe ser mayor a la hora de inicio.',
            'date.required'       => 'La fecha es obligatoria.',
            'start_time.required' => 'La hora de inicio es obligatoria.',
            'end_time.required'   => 'La hora de fin es obligatoria.',
        ];
    }
}