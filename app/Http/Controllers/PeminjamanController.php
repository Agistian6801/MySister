<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\PeminjamanDetail;
use App\Models\Barang;
use App\Models\User;
use App\Models\Anggota;
use App\Models\Kelas;
use App\Models\CcPeminjaman;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.peminjaman.index');
    }


    public function getPeminjaman()
    {
        $pdetail = PeminjamanDetail::rightJoin('peminjaman','peminjaman.id', '=', 'peminjaman_details.peminjaman_id')
                                    ->join('barangs', 'barangs.id', '=', 'peminjaman_details.barang_id')
                                    ->join('anggotas', 'anggotas.id', '=', 'peminjaman.anggota_id')
                                    ->join('users', 'users.id', '=', 'anggotas.user_id')
                                    ->join('kelas', 'kelas.id', '=', 'anggotas.kelas_id')
                                    ->select('peminjaman.*','peminjaman.id AS idpj', 'peminjaman_details.*', 'peminjaman_details.id AS idpjdetail', 'peminjaman_details.keterangan AS ketpinjam', 'barangs.*','barangs.id AS idbarang', 'anggotas.*', 'users.*', 'users.id AS iduser', 'kelas.*', 'kelas.id AS idkelas')
                                    ->orderBy('peminjaman.id', 'desc')
                                    ->get();

        return response()->json($pdetail);
    }

    public function getPeminjam()
    {
        $pj = Anggota::join('users', 'anggotas.user_id', '=', 'users.id')
                        ->select('anggotas.id', 'users.name')
                        ->orderBy('users.name', 'asc')
                        ->get();
        return response()->json($pj);
    }

    public function cariPeminjaman($merk)
    {
        $pdetail = PeminjamanDetail::rightJoin('peminjaman','peminjaman.id', '=', 'peminjaman_details.peminjaman_id')
                                    ->join('barangs', 'barangs.id', '=', 'peminjaman_details.barang_id')
                                    ->join('anggotas', 'anggotas.id', '=', 'peminjaman.anggota_id')
                                    ->join('users', 'users.id', '=', 'anggotas.user_id')
                                    ->join('kelas', 'kelas.id', '=', 'anggotas.kelas_id')
                                    ->select('peminjaman.*','peminjaman.id AS idpj', 'peminjaman_details.*', 'peminjaman_details.id AS idpjdetail', 'peminjaman_details.keterangan AS ketpinjam', 'barangs.*','barangs.id AS idbarang', 'anggotas.*', 'users.*', 'users.id AS iduser', 'kelas.*', 'kelas.id AS idkelas')
                                    ->where('peminjaman.tanggal_pinjam', 'LIKE' , '%' .$merk . '%')
                                    ->orWhere('peminjaman.id', 'LIKE' , '%' .$merk . '%')
                                    ->orWhere('peminjaman.tanggal_kembali', 'LIKE' , '%' .$merk . '%')
                                    ->orWhere('peminjaman.status', 'LIKE' , '%' .$merk . '%')
                                    ->orWhere('users.name', 'LIKE' ,'%' . $merk . '%')
                                    ->orWhere('barangs.merk', 'LIKE' ,'%' . $merk . '%')
                                    ->orWhere('barangs.id','LIKE' , '%' .$merk . '%')
                                    ->orWhere('peminjaman_details.keterangan', 'LIKE' ,'%' . $merk . '%')
                                    ->get();

        return response()->json($pdetail);
    }

    public function lihatCc($id)
    {
        $lihat = CcPeminjaman::join('anggotas', 'anggotas.id', '=', 'cc_peminjamen.anggota_id')
                                ->join('users', 'users.id', '=', 'anggotas.user_id')
                                ->select('users.name')
                                ->where('cc_peminjamen.peminjaman_id','=', $id)
                                ->get();
        
        return response()->json($lihat);
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
        $input = $request->all();
        // return response()->json($input);
        $peminjaman = Peminjaman::create([
            'tanggal_pinjam'    => $input ['tanggal_pinjam'],
            'tanggal_kembali'   => $input ['tanggal_kembali'],
            'anggota_id'        => $input ['anggota_id']
        ]);

        return response()->json($peminjaman->id);
    }

    public function storeDetail(Request $request)
    {
        $input = $request->toArray();
       
        for ($i=0; $i < count($input); $i++) {  
            $peminjamandetail = PeminjamanDetail::create([
                'peminjaman_id' =>$input[$i] ['peminjaman_id'],
                'barang_id'     =>$input[$i] ['barang_id'],
                'keterangan'    =>$input[$i] ['keterangan']
            ]);

            // $barang = Barang::where('id', '=', $input[$i] ['barang_id'])
            // ->update(['status_barang'=>'1']);
        }



        return response()->json($peminjamandetail);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Peminjaman  $peminjaman
     * @return \Illuminate\Http\Response
     */
    public function show(Peminjaman $peminjaman)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Peminjaman  $peminjaman
     * @return \Illuminate\Http\Response
     */
     public function edit( $id)
     {
        
        $pdetail = Peminjaman::find($id)->with('anggota.user');
                                    
                                    // ->join('anggotas', 'anggotas.id', '=', 'peminjaman.anggota_id')
                                    // ->join('users', 'users.id', '=', 'anggotas.user_id')
                                    
                                   
                                    

        return response()->json($pdetail);
     }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Peminjaman  $peminjaman
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Peminjaman $peminjaman)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Peminjaman  $peminjaman
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        $pinjam = Peminjaman::find($id);
        $pinjam->delete();

        return response()->json(["pesan" => "Deleted Succesfully"]);
    }

    public function peminjamanDelete($id)
     {
        $kategori = Peminjaman::find($id);
        $kategori->delete();
        return response()->json(['success'=>"Product Deleted successfully.", 'tr'=>'tr_'.$id]);
     }

    public function deleteAll(Request $request)
     {
         $ids = $request->ids;
         $pem = Peminjaman::whereIn('id',explode(",",$ids))->delete();
         return response()->json(['success'=>"Products Deleted successfully."]);
     }
}
