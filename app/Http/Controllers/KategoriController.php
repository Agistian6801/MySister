<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Validator;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.kategori.index');
    }

    public function getKategori()
    {
        $kategori = Kategori::orderBy('id', 'desc')->get();
        return response()->json($kategori);
    }

    public function cariKategori($merk)
    {
        
        $kategori = Kategori::where('kategori', 'LIKE' , '%' . $merk . '%')
        ->orWhere('ketkategori', 'LIKE' , '%' . $merk . '%')
        ->get();
        return response()->json($kategori);
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
           
            'kategori'   => 'required',
            'ketkategori'   => 'required',
         
            
        ]);

        $kategori = Kategori::create([
            'kategori'    => $input['kategori'],
            'ketkategori'   => $input['ketkategori'],
       
       
        ]);            

        return response()->json(["success"=>"Data Saved Successfully"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function show(Kategori $kategori)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function edit( $id)
    {
        $kategori = Kategori::find($id);
        return response()->json($kategori);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
     public function update(Request $request, $id)
     {
         $input = $request->all();
         $kategori = Kategori::find($id);
  
         $kategori->kategori   = $input['kategori'];
         $kategori->ketkategori   = $input['ketkategori'];
         $kategori->save();
  
          return response()->json(['pesan'    =>  'Berhasil Ubah']);
     }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        return response()->json(['pesan' => 'deleted']);
    }
 
 
     public function deleteAll(Request $request)
     {
         $ids = $request->ids;
         $kategori = Kategori::whereIn('id',explode(",",$ids))->delete();
         return response()->json(['success'=>"Products Deleted successfully."]);
     }
}
