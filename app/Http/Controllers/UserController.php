<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Validator;

class UserController extends Controller
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
        return view('admin.user.index');
    }

    public function getuser()
    {
        $user = User::orderBy('id', 'desc')->get();
        return response()->json($user);
    }

    public function cariAnggota($anggota)
    {
        $user = User::where('users.name', 'LIKE', '%' . $anggota . '%')
                    ->orWhere('users.email', 'LIKE', '%' . $anggota . '%')
                    ->get();
       
        return response()->json($user);
    }

    public function change($id)
    {
        $user = User::find($id);
        if ($user->is_admin == '0') {
            $user->update([
                'is_admin' => '1'
            ]);
        }else {
            $user->update([
                'is_admin' => '0'
            ]);
        }

       return response()->json($user);
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
             'name' => 'required',
             'email'   => 'required',
             'password'   => 'required',
           
         ]);
 
         if ($validator->passes()) {

             $user = User::create([

                 'name'    => $input['name'],
                 'email'   => $input['email'],
                 'password'     => Hash::make($input['password']),
              
             ]);            
 
             return response()->json(["success"=>"Data Saved Successfully"]);
         }
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
         
         $user = User::find($id);
         return response()->json($user);
         
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
        $input = $request->all();
        $user = User::find($id);

            $user->name   = $input['name'];
            $user->email   = $input['email'];
            $user->password   = Hash::make($input['password']);
            $user->save();

        return response()->json(['pesan'    =>  'Berhasil Ubah']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return response()->json(["pesan" => "Deleted Succesfully"]);
    }
}
