<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    use HasFactory;
    protected $table = 'pengembalians';
    protected $fillable = ['peminjaman_id','tanggal_kembali','keterangan'];

    /**
     * Get the peminjaman that owns the Pengembalian
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'peminjaman_id');
    }
}
