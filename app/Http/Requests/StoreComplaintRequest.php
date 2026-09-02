<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreComplaintRequest extends FormRequest
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
            'reporter_name' => ['nullable', 'string', 'max:191'],
            'reporter_contact' => ['nullable', 'string', 'max:191'],
            'is_disability_friendly' => ['nullable', 'boolean'],
            'title' => ['required', 'string', 'max:191'],
            'description' => ['required', 'string', 'min:20'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'attachments' => ['nullable', 'array', 'max:5'],
            'attachments.*' => ['file', 'mimes:jpg,jpeg,png,gif,mp4,mov,avi,webm', 'max:20480'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Judul pengaduan wajib diisi.',
            'title.max' => 'Judul tidak boleh lebih dari 191 karakter.',
            'description.required' => 'Deskripsi pengaduan wajib diisi.',
            'description.min' => 'Deskripsi terlalu singkat, minimal 20 karakter.',
            'category_id.required' => 'Pilih kategori pengaduan.',
            'category_id.exists' => 'Kategori tidak valid.',
            'attachments.max' => 'Maksimal 5 file lampiran.',
            'attachments.*.mimes' => 'Format file harus jpg, png, gif, mp4, mov, avi, atau webm.',
            'attachments.*.max' => 'Ukuran tiap file maksimal 20 MB.',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'reporter_name' => 'nama pelapor',
            'reporter_contact' => 'kontak pelapor',
            'title' => 'judul',
            'description' => 'deskripsi',
            'category_id' => 'kategori',
        ];
    }
}
