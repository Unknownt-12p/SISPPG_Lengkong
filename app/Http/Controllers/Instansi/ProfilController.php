<?php

namespace App\Http\Controllers\Instansi;

use App\Http\Controllers\Controller;
use App\Models\Instansi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ProfilController extends Controller
{
    /**
     * Tampilkan profil instansi saat ini.
     */
    public function show()
    {
        $user = Auth::user();
        $instansi = $user->instansi;

        if (!$instansi) {
            abort(403, 'Profil instansi tidak ditemukan. Silakan hubungi Administrator.');
        }

        return view('instansi.profil', compact('user', 'instansi'));
    }

    /**
     * Update profil instansi dan password akun login.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $instansi = $user->instansi;

        if (!$instansi) {
            abort(403, 'Profil instansi tidak ditemukan.');
        }

        $request->validate([
            'nama_instansi' => 'required|string|max:255',
            'penanggung_jawab' => 'required|string|max:255',
            'telepon' => 'required|string|max:20',
            'alamat' => 'required|string',
            'password' => 'nullable|string|min:6|confirmed',
        ], [
            'nama_instansi.required' => 'Nama instansi wajib diisi.',
            'penanggung_jawab.required' => 'Nama penanggung jawab wajib diisi.',
            'telepon.required' => 'Nomor telepon wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'password.min' => 'Password minimal harus 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        DB::beginTransaction();

        try {
            // 1. Update data profil
            $instansi->update([
                'nama_instansi' => $request->nama_instansi,
                'penanggung_jawab' => $request->penanggung_jawab,
                'telepon' => $request->telepon,
                'alamat' => $request->alamat,
            ]);

            // 2. Update password user jika diisi
            $userData = ['name' => $request->nama_instansi];
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }
            $user->update($userData);

            DB::commit();

            return redirect()->route('instansi.profil')
                ->with('success', 'Profil instansi berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui profil: ' . $e->getMessage())->withInput();
        }
    }
}
