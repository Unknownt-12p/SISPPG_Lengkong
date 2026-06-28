<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\InstansiRequest;
use App\Models\Instansi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class InstansiController extends Controller
{
    /**
     * Tampilkan daftar instansi (dengan Search & Pagination).
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $instansi = Instansi::when($search, function ($query) use ($search) {
            $query->where('kode_instansi', 'like', "%{$search}%")
                  ->orWhere('nama_instansi', 'like', "%{$search}%")
                  ->orWhere('penanggung_jawab', 'like', "%{$search}%")
                  ->orWhere('jenis_instansi', 'like', "%{$search}%");
        })->latest()->paginate(10)->withQueryString();

        return view('admin.instansi.index', compact('instansi', 'search'));
    }

    /**
     * Form tambah instansi.
     */
    public function create()
    {
        // Generate kode instansi otomatis untuk kemudahan input
        $lastInstansi = Instansi::latest()->first();
        if ($lastInstansi) {
            $num = (int) substr($lastInstansi->kode_instansi, 5) + 1;
            $kodeInstansi = 'INST-' . str_pad($num, 3, '0', STR_PAD_LEFT);
        } else {
            $kodeInstansi = 'INST-001';
        }

        return view('admin.instansi.create', compact('kodeInstansi'));
    }

    /**
     * Simpan instansi baru dan buat user login terkait.
     */
    public function store(InstansiRequest $request)
    {
        DB::beginTransaction();

        try {
            // 1. Buat User Account
            $user = User::create([
                'name' => $request->nama_instansi,
                'email' => $request->email,
                'password' => Hash::make('password'), // password default
                'role' => 'instansi',
            ]);

            // 2. Buat Profil Instansi
            Instansi::create([
                'kode_instansi' => $request->kode_instansi,
                'nama_instansi' => $request->nama_instansi,
                'jenis_instansi' => $request->jenis_instansi,
                'alamat' => $request->alamat,
                'penanggung_jawab' => $request->penanggung_jawab,
                'telepon' => $request->telepon,
                'email' => $request->email,
                'user_id' => $user->id,
            ]);

            DB::commit();

            return redirect()->route('admin.instansi.index')
                ->with('success', "Instansi {$request->nama_instansi} berhasil ditambahkan. Akun user login telah otomatis dibuat!");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan sistem saat menyimpan data: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Tampilkan detail instansi.
     */
    public function show($id)
    {
        $instansi = Instansi::findOrFail($id);
        return view('admin.instansi.show', compact('instansi'));
    }

    /**
     * Form edit instansi.
     */
    public function edit($id)
    {
        $instansi = Instansi::findOrFail($id);
        return view('admin.instansi.edit', compact('instansi'));
    }

    /**
     * Update data instansi dan sinkronisasikan ke user.
     */
    public function update(InstansiRequest $request, $id)
    {
        $instansi = Instansi::findOrFail($id);

        DB::beginTransaction();

        try {
            // 1. Update data user terkait jika email berubah
            if ($instansi->user) {
                $instansi->user->update([
                    'name' => $request->nama_instansi,
                    'email' => $request->email,
                ]);
            }

            // 2. Update data instansi
            $instansi->update($request->validated());

            DB::commit();

            return redirect()->route('admin.instansi.index')
                ->with('success', "Data instansi {$request->nama_instansi} berhasil diperbarui!");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Hapus instansi beserta user-nya.
     */
    public function destroy($id)
    {
        $instansi = Instansi::findOrFail($id);

        DB::beginTransaction();

        try {
            // Simpan nama instansi untuk notifikasi
            $nama = $instansi->nama_instansi;

            // Hapus user terkait (akan memicu delete cascade/set null tergantung database)
            if ($instansi->user) {
                $instansi->user->delete();
            } else {
                $instansi->delete();
            }

            DB::commit();

            return redirect()->route('admin.instansi.index')
                ->with('success', "Instansi {$nama} beserta akun loginnya berhasil dihapus.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus data instansi: ' . $e->getMessage());
        }
    }
}
