<?php

namespace App\Http\Controllers;

use App\Models\Pengembalian;
use App\Models\Peminjaman;
use App\Models\PeminjamanDetail;
use App\Models\Anggota;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Barang;
use Illuminate\Http\Request;

class PengembalianController extends Controller
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
        return view('admin.pengembalian.index');
    }

    // public function getpeminjaman()
    // {
    //     $pdetail = PeminjamanDetail::rightJoin('peminjaman','peminjaman.id', '=', 'peminjaman_details.peminjaman_id')
    //                                 ->join('barangs', 'barangs.id', '=', 'peminjaman_details.barang_id')
    //                                 ->join('anggotas', 'anggotas.id', '=', 'peminjaman.anggota_id')
    //                                 ->join('users', 'users.id', '=', 'anggotas.user_id')
    //                                 ->join('kelas', 'kelas.id', '=', 'anggotas.kelas_id')
    //                                 ->select('peminjaman.*','peminjaman.id AS idpj', 'peminjaman_details.*', 'peminjaman_details.id AS idpjdetail', 'peminjaman_details.keterangan AS ketpinjam', 'barangs.*', 'anggotas.*', 'users.*', 'users.id AS iduser', 'kelas.*', 'kelas.id AS idkelas')
    //                                 ->orderBy('peminjaman.id', 'desc')
    //                                 ->where('peminjaman.status', '=', '0')
    //                                 ->get();

    //     return response()->json($pdetail);
    // }

    public function getdatapeminjaman()
    {
        // $peminjaman = Peminjaman::with('peminjamandetail.barang')
                        
        //                 ->get();
        $peminjaman = Peminjaman::with('peminjamandetail.barang')
                        ->join('anggotas', 'anggotas.id', '=', 'peminjaman.anggota_id')
                        ->join('users', 'users.id', '=', 'anggotas.user_id')
                        ->join('kelas', 'kelas.id', '=', 'anggotas.kelas_id')
                        ->select('users.*', 'peminjaman.*', 'peminjaman.id AS idpeminjaman')
                        ->whereNotIn('peminjaman.id', function($query){
                            $query->select('peminjaman_id')->from('pengembalians');
                        })
                        ->get();

        return response()->json($peminjaman);
    }

    public function caridataPeminjaman($merk)
    {
        $peminjaman = Peminjaman::with('peminjamandetail.barang')
                        ->join('anggotas', 'anggotas.id', '=', 'peminjaman.anggota_id')
                        ->join('users', 'users.id', '=', 'anggotas.user_id')
                        ->join('kelas', 'kelas.id', '=', 'anggotas.kelas_id')
                        ->select('users.*', 'peminjaman.*', 'peminjaman.id AS idpeminjaman')
                        ->where('peminjaman.id', 'LIKE' ,'%' . $merk . '%')
                        ->orWhere('users.name', 'LIKE' ,'%' . $merk . '%')
                        ->get();

        return response()->json($peminjaman);
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
        $pengembalian = Pengembalian::create($request->all());
        
        $peminjaman = Peminjaman::where('id', '=', $request->peminjaman_id)
                      ->first();

        if ($peminjaman->status == 0) {
            $peminjaman = Peminjaman::where('id', '=', $request->peminjaman_id)
                        ->update(['status'=>'1']);
        }else if ($peminjaman->status == 2){
            $peminjaman = Peminjaman::where('id', '=', $request->peminjaman_id)
                        ->update(['status'=>'3']);
        }
        
        return response()->json(['saved']);
    }

    public function ubahStatus($id)
    {
        $peminjaman = Peminjaman::where('id', '=', $id)
                        ->update(['status'=>'2']);
        return response()->json($peminjaman);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pengembalian  $pengembalian
     * @return \Illuminate\Http\Response
     */
    public function show(Pengembalian $pengembalian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pengembalian  $pengembalian
     * @return \Illuminate\Http\Response
     */
    public function edit(Pengembalian $pengembalian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pengembalian  $pengembalian
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pengembalian $pengembalian)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pengembalian  $pengembalian
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pengembalian $pengembalian)
    {
        //
    }
}
