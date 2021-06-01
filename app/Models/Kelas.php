<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;
    protected $table = 'kelas';
    protected $fillable = ['kelas', 'jurusan', 'ruang'];

    public function anggota()
    {
        return $this->hasMany('App\Models\Anggota');
    }
}
