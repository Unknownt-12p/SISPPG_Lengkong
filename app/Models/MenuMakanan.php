<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuMakanan extends Model
{
    use HasFactory;

    protected $table = 'menu_makanan';

    protected $fillable = [
        'kode_menu',
        'nama_menu',
        'kategori_menu',
        'kalori',
        'protein',
        'karbohidrat',
        'lemak',
        'deskripsi',
    ];

    /**
     * Relationship to Penyaluran
     */
    public function penyaluran()
    {
        return $this->hasMany(Penyaluran::class, 'menu_id');
    }
}
