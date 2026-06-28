<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instansi extends Model
{
    use HasFactory;

    protected $table = 'instansi';

    protected $fillable = [
        'kode_instansi',
        'nama_instansi',
        'jenis_instansi',
        'alamat',
        'penanggung_jawab',
        'telepon',
        'email',
        'user_id',
    ];

    /**
     * Relationship to User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relationship to Pengajuan
     */
    public function pengajuan()
    {
        return $this->hasMany(Pengajuan::class, 'instansi_id');
    }
}
