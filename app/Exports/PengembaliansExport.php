<?php

namespace App\Exports;

use Illuminate\Http\Request;
use App\Models\Pengembalian;
use App\Models\Peminjaman;
use App\Models\PeminjamanDetail;
use App\Models\Anggota;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Barang;
use App\Models\CcPeminjaman;
use Maatwebsite\Excel\Concerns\FromCollection;

class PengembaliansExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $report = Pengembalian::join('peminjaman', 'pengembalians.peminjaman_id', '=', 'peminjaman.id')
        ->join('anggotas', 'peminjaman.anggota_id', '=', 'anggotas.id')
        ->join('users', 'anggotas.user_id', '=', 'users.id')
        ->join('kelas', 'anggotas.kelas_id', '=', 'kelas.id')
        // ->leftJoin('cc_peminjamen', 'peminjaman.id', '=', 'cc_peminjamen.peminjaman_id')
        ->join('peminjaman_details', 'peminjaman.id', '=', 'peminjaman_details.peminjaman_id')
        ->join('barangs', 'peminjaman_details.barang_id', '=', 'barangs.id')
        ->join('kategoris', 'barangs.kategori_id', '=', 'kategoris.id')
        ->select('pengembalians.id', 'peminjaman.tanggal_pinjam', 'peminjaman.tanggal_kembali AS tanggal_harus_kembali', 'pengembalians.tanggal_kembali',
                'users.name', 'kelas.kelas', 'kelas.jurusan', 'kelas.ruang', 'barangs.merk', 'barangs.SN', 'barangs.lokasi', 'kategoris.kategori',
               'peminjaman.status', Pengembalian::raw('(CASE WHEN peminjaman.status = 1 THEN "Dikembalikan tepat waktu" WHEN peminjaman.status = 3 THEN "Dikembalikan tapi terlambat" ELSE "Belum dikembalikan" END) AS status'),
                Pengembalian::raw('(CASE WHEN cc_peminjamen.anggota_id = null THEN "Tidak ada anggota" ELSE cc_peminjamen.anggota_id END) AS anggota_id'))
        ->get();

        return $report;

    }
}
