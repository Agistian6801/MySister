<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; 
use App\Models\Kategori;
use App\Models\Barang;
use App\Models\User;
use App\Models\Anggota;
use App\Models\Peminjaman;
use App\Models\PeminjamanDetail;
use App\Models\Kelas;
use App\Models\CcPeminjaman;
use Auth;

class FrontendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    

    
    public function index()
    {
        // return view('home');
        return view('frontend.home');
    }

    public function getkategori()
    {
        $kategori = Kategori::all();
        return response()->json($kategori);
    }

    public function getbarang()
    {
        $barang = Barang::join('kategoris', 'barangs.kategori_id', '=', 'kategoris.id')
                        ->select('barangs.*', 'barangs.id AS idbarang', 'kategoris.*')
                        ->where('barangs.status_barang', '=', '0')
                        ->get();
        return response()->json($barang);
    }

    public function cariBarang($merk)
    {
        $barang = Barang::join('kategoris', 'barangs.kategori_id', '=', 'kategoris.id')
                        ->select('barangs.*', 'barangs.id AS idbarang', 'kategoris.*')
                        ->where([['barangs.id', 'LIKE' ,'%' . $merk . '%'],['barangs.status_barang', '=', '0']])
                        ->orWhere([['barangs.merk', 'LIKE' ,'%' . $merk . '%'],['barangs.status_barang', '=', '0']])
                        ->orWhere([['barangs.SN', 'LIKE' ,'%' . $merk . '%'],['barangs.status_barang', '=', '0']])
                        ->orWhere([['barangs.lokasi', 'LIKE' ,'%' . $merk . '%'],['barangs.status_barang', '=', '0']])
                        ->get();

        return response()->json($barang);
    }

    public function cariAnggota($userId)
    {
        $anggota = Anggota::where('anggotas.user_id', '=', $userId)
                            ->get();
        return response()->json($anggota);
    }

    public function daftarAnggota()
    {
        return view('frontend.daftaranggota');
    }

    public function getkelas()
    {
        $kelas = Kelas::all();
        return response()->json($kelas);
    }

    public function storeAnggota(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($request->all(),[
            'user_id'   => 'required',
            'selkelas'   => 'required',
            'alamat'   => 'required',
            'no_telp'   => 'required',
            'jk'   => 'required'
        ]);

        if ($validator->passes()) {

            $anggota = Anggota::create([
                'user_id'    => $input['user_id'],
                'kelas_id'   => $input['selkelas'],
                'alamat'     => $input['alamat'],
                'no_telp'    => $input['no_telp'],
                'jk'         => $input['jk'],
            ]);            

            return redirect('/');
            // return response()->json($anggota);
        }
    }

    public function getanggotaid($userId)
    {
        $user = User::join('anggotas', 'anggotas.user_id', '=', 'users.id')
                        ->where('users.id', '=', $userId)
                        ->select('anggotas.id')
                        ->get();
        return response()->json($user);
    }
    
    
    public function getPeminjaman($userId)
    {
        // // $id = Auth::user()->id;
        // $ai = Anggota::where('user_id', '=', $id)->select('anggotas.id')->get();
        // $pi = Peminjaman::where('anggota_id', '=', $ai)
        // // ->get();

        $pdetail = PeminjamanDetail::rightJoin('peminjaman','peminjaman.id', '=', 'peminjaman_details.peminjaman_id')
                                    ->join('barangs', 'barangs.id', '=', 'peminjaman_details.barang_id')
                                    ->join('anggotas', 'anggotas.id', '=', 'peminjaman.anggota_id')
                                    ->join('users', 'users.id', '=', 'anggotas.user_id')
                                    ->join('kelas', 'kelas.id', '=', 'anggotas.kelas_id')
                                    ->where('peminjaman.anggota_id', '=', $userId)
                                    ->select('peminjaman.*','peminjaman.id AS idpj', 'peminjaman_details.*', 'peminjaman_details.id AS idpjdetail', 'peminjaman_details.keterangan AS ketpinjam', 'barangs.*','barangs.id AS idbarang', 'anggotas.*', 'users.*', 'users.id AS iduser', 'kelas.*', 'kelas.id AS idkelas')
                                    ->get();

        return response()->json($pdetail);
        
       
    }

    public function indexPeminjamanku()
    {
        return view('frontend.peminjamanku');
    }

    public function getPeminjam()
    {
        $pj = Anggota::join('users', 'anggotas.user_id', '=', 'users.id')
                        ->select('anggotas.id', 'users.name')
                        ->orderBy('users.name', 'asc')
                        ->get();
        return response()->json($pj);
    }

    public function Cc($id)
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
            'anggota_id'        => $input ['anggota_id'],
        ]);

        return response()->json($peminjaman->id);
    }

    public function storeDetail(Request $request)
    {
        $input = $request->all();
       
        // for ($i=0; $i < count($input); $i++) {  
            $peminjamandetail = PeminjamanDetail::create([
                'peminjaman_id' =>$input ['peminjaman_id'],
                'barang_id'     =>$input ['barang_id'],
                'keterangan'    =>$input ['keterangan']
            ]);

        return response()->json($peminjamandetail);
    }

    public function storeCc(Request $request)
    {
        $input = $request->toArray();
       
        for ($i=0; $i < count($input); $i++) {  
            $ccpeminjaman = CcPeminjaman::create([
                'peminjaman_id' =>$input[$i] ['peminjaman_id'],
                'anggota_id'     =>$input[$i] ['anggota_id']
            ]);

            // $barang = Barang::where('id', '=', $input[$i] ['barang_id'])
            // ->update(['status_barang'=>'1']);
        }



        return response()->json($ccpeminjaman);
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
