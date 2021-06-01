<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\File; 

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.barang.index');
    }

    public function getBarang()
    {
        // $barang = Barang::orderBy('id', 'desc')->get();
        // return response()->json($barang);

        $barang = Barang::join('kategoris', 'barangs.kategori_id', '=', 'kategoris.id')
                    ->orderBy('barangs.id', 'desc')
                    ->get(['barangs.*' ,'barangs.id AS idbarang', 'kategoris.*', 'kategoris.id AS idkategori']);
        
        return response()->json($barang);
    }

    public function getKategori()
    {
        $kategori = Kategori::all();

        return response()->json($kategori);
    }

    public function cariBarang($merk)
    {
        
        $barang = Barang::join('kategoris', 'barangs.kategori_id', '=', 'kategoris.id')
        ->where('merk', 'LIKE' , '%' . $merk . '%')
        ->orWhere('keterangan', 'LIKE' , '%' . $merk . '%')
        ->orWhere('jumlah', 'LIKE' , '%' . $merk . '%')
        ->orWhere('satuan', 'LIKE' , '%' . $merk . '%')
        ->orWhere('status_barang', 'LIKE' , '%' . $merk . '%')
        ->orWhere('spesifikasi', 'LIKE' , '%' . $merk . '%')
        ->orWhere('kategoris.kategori', 'LIKE' , '%' . $merk . '%')
        ->orWhere('lokasi', 'LIKE' , '%' . $merk . '%')
        ->orWhere('SN', 'LIKE' , '%' . $merk . '%')
        ->get(['barangs.*' ,'barangs.id AS idbarang','kategoris.*']);
        return response()->json($barang);
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
            'foto' => 'required',
            'merk'   => 'required',
            'keterangan'   => 'required',
            'satuan'   => 'required',
            'jumlah'   => 'required',
            'SN'   => 'required',
            'selkondisi'   => 'required',
            'selkategori'   => 'required',
            'spesifikasi'   => 'required',
            'lokasi'   => 'required',
            
        ]);

        if ($validator->passes()) {

            $imageName = time() . '.' . request()->foto->getClientOriginalExtension();

            request()->foto->move(public_path('photos'), $imageName);

            $barang = Barang::create([
                'merk'    => $input['merk'],
                'keterangan'   => $input['keterangan'],
                'satuan'     => $input['satuan'],
                'jumlah'    => $input['jumlah'],
                'SN'    => $input['SN'],
                'status_barang'    => $input['selkondisi'],
                'kategori_id'    => $input['selkategori'],
                'spesifikasi'    => $input['spesifikasi'],
                'lokasi'    => $input['lokasi'],
                'foto'       => $imageName
            ]);            

            return response()->json(["success"=>"Data Saved Successfully"]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function show(Barang $barang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
     public function edit($id)
    {
        $barang = Barang::find($id);
        return response()->json($barang);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
     public function update(Request $request,  $id)
     {
         $input = $request->all();
         $barang = Barang::find($id);
         
         
 
         if ($request->hasFile('foto')) {
             
            $image_path = public_path("photos/{$barang->foto}");
            File::delete($image_path);
 
             $imageName = time() . '.' . request()->foto->getClientOriginalExtension();
 
             request()->foto->move(public_path('photos'), $imageName);
                 
               
         } else {
             $imageName = $barang->foto;
         }
 
             $barang->merk   = $input['merk'];
             $barang->keterangan   = $input['keterangan'];
             $barang->satuan   = $input['satuan'];
             $barang->jumlah   = $input['jumlah'];
             $barang->spesifikasi   = $input['spesifikasi'];
             $barang->SN   = $input['SN'];
             $barang->status_barang   = $input['selkondisi'];
             $barang->lokasi   = $input['lokasi'];
             $barang->kategori_id   = $input['selkategori'];
             $barang->foto  = $imageName;
             $barang->save();
 
         return response()->json(['pesan'    =>  'Berhasil Ubah']);
     }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
     public function destroy($id)
     {
         $barang = Barang::findOrFail($id);
         $image_path = public_path("photos/{$barang->foto}");
         
         if (File::exists($image_path)) {
             File::delete($image_path);
             // unlink($image_path);
         }
 
         $barang->delete();
 
         return response()->json(["pesan" => "Deleted Succesfully"]);
     }

     public function deleteAll(Request $request)
     {
         $ids = $request->ids;
         $pem = Barang::whereIn('id',explode(",",$ids))->delete();
         return response()->json(['success'=>"Products Deleted successfully."]);
     }
}
