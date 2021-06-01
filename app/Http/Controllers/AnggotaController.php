<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\User;
use App\Models\Kelas;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; 

class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.anggota.index');
    }

    public function getanggota()
    {
        // $anggota = User::with('anggota.kelas')->get();
        $anggota = Anggota::rightJoin('users', 'anggotas.user_id', '=', 'users.id')
                    ->join('kelas', 'anggotas.kelas_id', '=', 'kelas.id')
                    ->orderBy('anggotas.id', 'desc')
                    ->get(['users.*','kelas.*', 'anggotas.*']);
        return response()->json($anggota);
    }

    public function getuser()
    {
        $user = User::all();
        return response()->json($user);
    }

    public function getkelas()
    {
        $kelas = Kelas::all();
        return response()->json($kelas);
    }

    public function cariAnggota($anggota)
    {
        $ang = Anggota::rightJoin('users', 'anggotas.user_id', '=', 'users.id')
                    ->join('kelas', 'anggotas.kelas_id', '=', 'kelas.id')
                    ->where('users.name', 'LIKE', '%' . $anggota . '%')
                    ->orWhere('anggotas.alamat', 'LIKE', '%' . $anggota . '%')
                    ->orWhere('kelas.kelas',  'LIKE', '%' . $anggota . '%')
                    ->orWhere('kelas.jurusan',  'LIKE', '%' . $anggota . '%')
                    ->orWhere('kelas.ruang',  'LIKE', '%' . $anggota . '%')
                    ->get();
       
        return response()->json($ang);
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
            'seluser'   => 'required',
            'selkelas'   => 'required',
            'alamat'   => 'required',
            'no_telp'   => 'required',
            'jk'   => 'required'
        ]);

        if ($validator->passes()) {

            $imageName = time() . '.' . request()->foto->getClientOriginalExtension();

            request()->foto->move(public_path('photos'), $imageName);

            $anggota = Anggota::create([
                'user_id'    => $input['seluser'],
                'kelas_id'   => $input['selkelas'],
                'alamat'     => $input['alamat'],
                'no_telp'    => $input['no_telp'],
                'jk'         => $input['jk'],
                'foto'       => $imageName
            ]);            

            return response()->json(["success"=>"Data Saved Successfully"]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Anggota  $anggota
     * @return \Illuminate\Http\Response
     */
    public function show(Anggota $anggota)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Anggota  $anggota
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $anggota = Anggota::find($id);
        return response()->json($anggota);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Anggota  $anggota
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        $input = $request->all();
        $anggota = Anggota::find($id);
        
        

        if ($request->hasFile('foto')) {
            
            $image_path = public_path("photos/{$anggota->foto}");
            File::delete($image_path);

            $imageName = time() . '.' . request()->foto->getClientOriginalExtension();

            request()->foto->move(public_path('photos'), $imageName);
                
              
        } else {
            $imageName = $anggota->foto;
        }

            $anggota->user_id   = $input['seluser'];
            $anggota->kelas_id   = $input['selkelas'];
            $anggota->alamat   = $input['alamat'];
            $anggota->no_telp   = $input['no_telp'];
            $anggota->jk   = $input['jk'];
            $anggota->foto  = $imageName;
            $anggota->save();

        return response()->json(['pesan'    =>  'Berhasil Ubah']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Anggota  $anggota
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $anggota = Anggota::findOrFail($id);
        $image_path = public_path("photos/{$anggota->foto}");
        
        if (File::exists($image_path)) {
            File::delete($image_path);
            // unlink($image_path);
        }

        $anggota->delete();

        return response()->json(["pesan" => "Deleted Succesfully"]);
    }
}
