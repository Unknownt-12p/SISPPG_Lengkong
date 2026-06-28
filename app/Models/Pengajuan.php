<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;

    protected $table = 'pengajuan';

    protected $fillable = [
        'kode_pengajuan',
        'instansi_id',
        'kategori_penerima',
        'jumlah_penerima',
        'jumlah_porsi',
        'tanggal_pengajuan',
        'tanggal_distribusi',
        'status',
        'catatan',
    ];

    /**
     * Relationship to Instansi
     */
    public function instansi()
    {
        return $this->belongsTo(Instansi::class, 'instansi_id');
    }

    /**
     * Relationship to Penyaluran
     */
    public function penyaluran()
    {
        return $this->hasOne(Penyaluran::class, 'pengajuan_id');
    }
}
