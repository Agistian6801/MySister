<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CcPeminjaman extends Model
{
    use HasFactory;
    protected $table = 'cc_peminjamen';
    protected $fillable = ['peminjaman_id', 'anggota_id'];

    /**
     * Get the user that owns the CcPeminjaman
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'peminjaman_id');
    }

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'anggota_id');
    }
}
