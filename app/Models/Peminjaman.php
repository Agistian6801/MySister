<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;
    protected $table = 'peminjaman';
    protected $fillable = ['tanggal_pinjam','tanggal_kembali','anggota_id','status', 'cc_anggota'];

    /**
     * Get the anggota that owns the Peminjaman
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    /**
     * Get all of the pengembalian for the Peminjaman
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pengembalian()
    {
        return $this->hasMany(Pengembalian::class);
    }

    
    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'anggota_id');
    }

    /**
     * Get all of the comments for the Peminjaman
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function peminjamandetail()
    {
        return $this->hasMany(PeminjamanDetail::class);
    }

    public function ccpeminjaman()
    {
        return $this->hasMany(CcPeminjaman::class);
    }
}

