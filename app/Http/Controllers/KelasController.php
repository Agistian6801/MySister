<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;
use Validator;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.kelas.index');
    }

    public function getKelas()
    {
        $kelas = Kelas::orderBy('id', 'desc')->get();
        return response()->json($kelas);
    }

    public function cariKelas($merk)
    {
        
        $kelas = Kelas::where('kelas', 'LIKE' , '%' . $merk . '%')
        ->orWhere('jurusan', 'LIKE' , '%' . $merk . '%')
        ->orWhere('ruang', 'LIKE' , '%' . $merk . '%')
        ->get();
        return response()->json($kelas);
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

        $validator = Validator::make($request->all(),[
           
            'kelas'   => 'required',
            'jurusan'   => 'required',
            'ruang'   => 'required',
            
        ]);

        $kelas = Kelas::create([
            'kelas'    => $input['kelas'],
            'jurusan'   => $input['jurusan'],
            'ruang'     => $input['ruang']
       
        ]);            

        return response()->json(["success"=>"Data Saved Successfully"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function show(Kelas $kelas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kelas = Kelas::find($id);
        return response()->json($kelas);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $kelas = Kelas::find($id);
 
        $kelas->kelas   = $input['kelas'];
        $kelas->jurusan   = $input['jurusan'];
        $kelas->ruang   = $input['ruang'];
        $kelas->save();
 
         return response()->json(['pesan'    =>  'Berhasil Ubah']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();

        return response()->json(['pesan' => 'Deleted']);
    }
}
