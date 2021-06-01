<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengembalian;
use App\Models\Peminjaman;
use App\Models\PeminjamanDetail;
use App\Models\Anggota;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Barang;
use App\Models\CcPeminjaman;
use PDF;
use App\Exports\PengembaliansExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportPengembalian extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
     {
         $this->middleware('auth');
     }
    
    public function index()
    {
        
        $report = Pengembalian::join('peminjaman', 'pengembalians.peminjaman_id', '=', 'peminjaman.id')
        // ->leftJoin('cc_peminjamen', 'peminjaman.id', '=', 'cc_peminjamen.peminjaman_id')
        ->join('anggotas', 'peminjaman.anggota_id', '=', 'anggotas.id')
        // ->join('anggotas', 'cc_peminjamen.anggota_id', '=', 'anggotas.id')
        ->join('users', 'anggotas.user_id', '=', 'users.id')
        ->join('kelas', 'anggotas.kelas_id', '=', 'kelas.id')
        ->join('peminjaman_details', 'peminjaman.id', '=', 'peminjaman_details.peminjaman_id')
        ->join('barangs', 'peminjaman_details.barang_id', '=', 'barangs.id')
        ->join('kategoris', 'barangs.kategori_id', '=', 'kategoris.id')
        ->select('pengembalians.id', 'pengembalians.tanggal_kembali','peminjaman.id AS id_peminjaman' ,'peminjaman.tanggal_pinjam', 'peminjaman.tanggal_kembali AS tanggal_harus_kembali','peminjaman.status',
                'users.name', 'kelas.kelas', 'kelas.jurusan', 'kelas.ruang', 'barangs.merk', 'barangs.SN', 'barangs.lokasi', 'kategoris.kategori')
        ->get();

        // $report = Peminjaman::with('CcPeminjaman')
        // ->join('anggotas', 'peminjaman.anggota_id', '=', 'anggotas.id')
        // ->join('users', 'anggotas.user_id', '=', 'users.id')
        // ->join('kelas', 'anggotas.kelas_id', '=', 'kelas.id')
        // ->join('peminjaman_details', 'peminjaman.id', '=', 'peminjaman_details.peminjaman_id')
        // ->join('barangs', 'peminjaman_details.barang_id', '=', 'barangs.id')
        // ->join('kategoris', 'barangs.kategori_id', '=', 'kategoris.id')
        // ->join('pengembalians', 'peminjaman.id', '=', 'pengembalians.peminjaman_id')
        // ->select('peminjaman.id' ,'peminjaman.tanggal_pinjam', 'peminjaman.tanggal_kembali AS tanggal_harus_kembali','peminjaman.status', 'pengembalians.tanggal_kembali',
        //         'users.name', 'kelas.kelas', 'kelas.jurusan', 'kelas.ruang', 'barangs.merk', 'barangs.SN', 'barangs.lokasi', 'kategoris.kategori',
        //        )
        // ->get();

        // return response()->json($report);
        return view('admin.report.pengembalian', compact('report'));
    }

    public function report()
    {
        $report = Pengembalian::join('peminjaman', 'pengembalians.peminjaman_id', '=', 'peminjaman.id')
        ->join('anggotas', 'peminjaman.anggota_id', '=', 'anggotas.id')
        ->join('users', 'anggotas.user_id', '=', 'users.id')
        ->join('kelas', 'anggotas.kelas_id', '=', 'kelas.id')
        // ->leftJoin('cc_peminjamen', 'peminjaman.id', '=', 'cc_peminjamen.peminjaman_id')
        ->join('peminjaman_details', 'peminjaman.id', '=', 'peminjaman_details.peminjaman_id')
        ->join('barangs', 'peminjaman_details.barang_id', '=', 'barangs.id')
        ->join('kategoris', 'barangs.kategori_id', '=', 'kategoris.id')
        ->select('pengembalians.id', 'pengembalians.tanggal_kembali', 'peminjaman.tanggal_pinjam', 'peminjaman.tanggal_kembali AS tanggal_harus_kembali','peminjaman.status',
                'users.name', 'kelas.kelas', 'kelas.jurusan', 'kelas.ruang', 'barangs.merk', 'barangs.SN', 'barangs.lokasi', 'kategoris.kategori')
        ->get();

        $pdf = PDF::loadView('admin.report.cetakpdf', compact('report'))->setPaper('a4', 'landscape');

        return $pdf->download('LaporanPengembalian.pdf');
    }

    public function export() 
    {
        return Excel::download(new PengembaliansExport, 'pengembalians.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
