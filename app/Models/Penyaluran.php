<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyaluran extends Model
{
    use HasFactory;

    protected $table = 'penyaluran';

    protected $fillable = [
        'kode_penyaluran',
        'pengajuan_id',
        'menu_id',
        'tanggal_penyaluran',
        'jumlah_disalurkan',
        'status_pengiriman',
        'keterangan',
    ];

    /**
     * Relationship to Pengajuan
     */
    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class, 'pengajuan_id');
    }

    /**
     * Relationship to MenuMakanan
     */
    public function menu_makanan()
    {
        return $this->belongsTo(MenuMakanan::class, 'menu_id');
    }
}
