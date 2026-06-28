<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MenuMakananRequest;
use App\Models\MenuMakanan;
use Illuminate\Http\Request;

class MenuMakananController extends Controller
{
    /**
     * Tampilkan daftar menu makanan.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $menu = MenuMakanan::when($search, function ($query) use ($search) {
            $query->where('kode_menu', 'like', "%{$search}%")
                  ->orWhere('nama_menu', 'like', "%{$search}%")
                  ->orWhere('kategori_menu', 'like', "%{$search}%");
        })->latest()->paginate(10)->withQueryString();

        return view('admin.menu.index', compact('menu', 'search'));
    }

    /**
     * Form tambah menu.
     */
    public function create()
    {
        // Generate kode menu otomatis
        $lastMenu = MenuMakanan::latest()->first();
        if ($lastMenu) {
            $num = (int) substr($lastMenu->kode_menu, 5) + 1;
            $kodeMenu = 'MENU-' . str_pad($num, 3, '0', STR_PAD_LEFT);
        } else {
            $kodeMenu = 'MENU-001';
        }

        return view('admin.menu.create', compact('kodeMenu'));
    }

    /**
     * Simpan menu baru.
     */
    public function store(MenuMakananRequest $request)
    {
        MenuMakanan::create($request->validated());

        return redirect()->route('admin.menu.index')
            ->with('success', "Menu {$request->nama_menu} berhasil ditambahkan!");
    }

    /**
     * Detail menu makanan.
     */
    public function show($id)
    {
        $menu = MenuMakanan::findOrFail($id);
        return view('admin.menu.show', compact('menu'));
    }

    /**
     * Form edit menu.
     */
    public function edit($id)
    {
        $menu = MenuMakanan::findOrFail($id);
        return view('admin.menu.edit', compact('menu'));
    }

    /**
     * Update menu makanan.
     */
    public function update(MenuMakananRequest $request, $id)
    {
        $menu = MenuMakanan::findOrFail($id);
        $menu->update($request->validated());

        return redirect()->route('admin.menu.index')
            ->with('success', "Menu {$request->nama_menu} berhasil diperbarui!");
    }

    /**
     * Hapus menu makanan.
     */
    public function destroy($id)
    {
        $menu = MenuMakanan::findOrFail($id);
        $nama = $menu->nama_menu;
        $menu->delete();

        return redirect()->route('admin.menu.index')
            ->with('success', "Menu {$nama} berhasil dihapus.");
    }
}
