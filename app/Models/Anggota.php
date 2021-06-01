<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;
    protected $table = 'anggotas';
    protected $fillable = ['user_id', 'kelas_id','alamat','no_telp','jk','foto'];

    /**
     * Get the user that owns the Anggota
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function kelas()
    {
        return $this->belongsTo('App\Models\Kelas', 'kelas_id');
    }

    /**
     * Get all of the peminjaman for the Anggota
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }

    public function ccpeminjaman()
    {
        return $this->hasMany(CcPeminjaman::class);
    }
}
