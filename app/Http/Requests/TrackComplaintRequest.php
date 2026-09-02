<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrackComplaintRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'tracking_code' => ['required', 'string', 'max:20'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'tracking_code.required' => 'Kode pengaduan wajib diisi.',
            'tracking_code.max' => 'Kode pengaduan tidak valid.',
        ];
    }
}
