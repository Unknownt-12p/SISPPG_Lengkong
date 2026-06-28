<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PenyaluranRequest extends FormRequest
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
            'pengajuan_id' => 'required|exists:pengajuan,id',
            'menu_id' => 'required|exists:menu_makanan,id',
            'tanggal_penyaluran' => 'required|date',
            'jumlah_disalurkan' => 'required|integer|min:1',
            'status_pengiriman' => 'required|in:Diproses,Dikirim,Selesai',
            'keterangan' => 'nullable|string',
        ];
    }

    /**
     * Custom validation messages in Indonesian.
     */
    public function messages(): array
    {
        return [
            'pengajuan_id.required' => 'Pengajuan wajib dipilih.',
            'pengajuan_id.exists' => 'Pengajuan tidak valid.',
            'menu_id.required' => 'Menu makanan wajib dipilih.',
            'menu_id.exists' => 'Menu makanan tidak valid.',
            'tanggal_penyaluran.required' => 'Tanggal penyaluran wajib diisi.',
            'tanggal_penyaluran.date' => 'Format tanggal tidak valid.',
            'jumlah_disalurkan.required' => 'Jumlah disalurkan wajib diisi.',
            'jumlah_disalurkan.integer' => 'Jumlah disalurkan harus berupa angka.',
            'jumlah_disalurkan.min' => 'Jumlah disalurkan minimal 1 porsi.',
            'status_pengiriman.required' => 'Status pengiriman wajib dipilih.',
            'status_pengiriman.in' => 'Status pengiriman tidak valid.',
        ];
    }
}
