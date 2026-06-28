<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InstansiRequest extends FormRequest
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
        $id = $this->route('instansi'); // Ambil ID instansi dari rute jika sedang update

        return [
            'kode_instansi' => 'required|string|unique:instansi,kode_instansi,' . $id,
            'nama_instansi' => 'required|string|max:255',
            'jenis_instansi' => 'required|in:TK,SD,Posyandu,Puskesmas',
            'alamat' => 'required|string',
            'penanggung_jawab' => 'required|string|max:255',
            'telepon' => 'required|string|max:20',
            'email' => 'required|email|unique:instansi,email,' . $id,
        ];
    }

    /**
     * Custom validation messages in Indonesian.
     */
    public function messages(): array
    {
        return [
            'kode_instansi.required' => 'Kode instansi wajib diisi.',
            'kode_instansi.unique' => 'Kode instansi ini sudah digunakan.',
            'nama_instansi.required' => 'Nama instansi wajib diisi.',
            'jenis_instansi.required' => 'Jenis instansi wajib dipilih.',
            'jenis_instansi.in' => 'Jenis instansi tidak valid.',
            'alamat.required' => 'Alamat wajib diisi.',
            'penanggung_jawab.required' => 'Nama penanggung jawab wajib diisi.',
            'telepon.required' => 'Nomor telepon wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.unique' => 'Alamat email ini sudah terdaftar.',
        ];
    }
}
