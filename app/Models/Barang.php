<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $table = 'barangs';
    protected $fillable = ['merk', 'keterangan', 'satuan', 'foto','jumlah', 'status_barang', 'kategori_id', 'spesifikasi', 'lokasi', 'SN'];

    /**
     * Get all of the comments for the Barang
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function peminjamandetail()
    {
        return $this->hasMany(PeminjamanDetail::class);
    }

    /**
     * Get the kategori that owns the Barang
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

}
