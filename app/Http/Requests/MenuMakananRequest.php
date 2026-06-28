<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MenuMakananRequest extends FormRequest
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
        $id = $this->route('menu'); // Ambil ID menu dari rute jika sedang update

        return [
            'kode_menu' => 'required|string|unique:menu_makanan,kode_menu,' . $id,
            'nama_menu' => 'required|string|max:255',
            'kategori_menu' => 'required|in:Anak TK,Anak SD,Balita,Ibu Hamil,Ibu Menyusui',
            'kalori' => 'required|integer|min:0',
            'protein' => 'required|integer|min:0',
            'karbohidrat' => 'required|integer|min:0',
            'lemak' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
        ];
    }

    /**
     * Custom validation messages in Indonesian.
     */
    public function messages(): array
    {
        return [
            'kode_menu.required' => 'Kode menu wajib diisi.',
            'kode_menu.unique' => 'Kode menu ini sudah digunakan.',
            'nama_menu.required' => 'Nama menu wajib diisi.',
            'kategori_menu.required' => 'Kategori menu wajib dipilih.',
            'kategori_menu.in' => 'Kategori menu tidak valid.',
            'kalori.required' => 'Jumlah kalori wajib diisi.',
            'kalori.integer' => 'Jumlah kalori harus berupa angka.',
            'kalori.min' => 'Jumlah kalori tidak boleh negatif.',
            'protein.required' => 'Jumlah protein wajib diisi.',
            'protein.integer' => 'Jumlah protein harus berupa angka.',
            'protein.min' => 'Jumlah protein tidak boleh negatif.',
            'karbohidrat.required' => 'Jumlah karbohidrat wajib diisi.',
            'karbohidrat.integer' => 'Jumlah karbohidrat harus berupa angka.',
            'karbohidrat.min' => 'Jumlah karbohidrat tidak boleh negatif.',
            'lemak.required' => 'Jumlah lemak wajib diisi.',
            'lemak.integer' => 'Jumlah lemak harus berupa angka.',
            'lemak.min' => 'Jumlah lemak tidak boleh negatif.',
        ];
    }
}
