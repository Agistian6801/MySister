<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('frontend.home');
    }

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

    
}
