<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PengajuanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'kategori_penerima' => 'required|in:Anak TK,Anak SD,Balita,Ibu Hamil,Ibu Menyusui',
            'jumlah_penerima' => 'required|integer|min:1',
            'jumlah_porsi' => 'required|integer|min:1',
            'tanggal_distribusi' => 'required|date|after_or_equal:today',
            'catatan' => 'nullable|string',
        ];
    }

    /**
     * Custom validation messages in Indonesian.
     */
    public function messages(): array
    {
        return [
            'kategori_penerima.required' => 'Kategori penerima wajib dipilih.',
            'kategori_penerima.in' => 'Kategori penerima tidak valid.',
            'jumlah_penerima.required' => 'Jumlah penerima wajib diisi.',
            'jumlah_penerima.integer' => 'Jumlah penerima harus berupa angka.',
            'jumlah_penerima.min' => 'Jumlah penerima minimal 1 orang.',
            'jumlah_porsi.required' => 'Jumlah porsi wajib diisi.',
            'jumlah_porsi.integer' => 'Jumlah porsi harus berupa angka.',
            'jumlah_porsi.min' => 'Jumlah porsi minimal 1 porsi.',
            'tanggal_distribusi.required' => 'Tanggal rencana distribusi wajib diisi.',
            'tanggal_distribusi.date' => 'Format tanggal tidak valid.',
            'tanggal_distribusi.after_or_equal' => 'Tanggal rencana distribusi harus hari ini atau setelahnya.',
        ];
    }
}
