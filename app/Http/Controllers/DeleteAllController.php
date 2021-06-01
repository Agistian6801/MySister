<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Validator;

class DeleteAllController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index()
     {
         $products = Kategori::all();
         return view('admin.kategori.kategori',compact('products'));
     }
 
     public function destroy($id)
     {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();
        return response()->json(['success'=>"Product Deleted successfully.", 'tr'=>'tr_'.$id]);
     }
 
 
     public function deleteAll(Request $request)
     {
         $ids = $request->ids;
         $kategori = Kategori::whereIn('id',explode(",",$ids))->delete();
         return response()->json(['success'=>"Products Deleted successfully."]);
     }
}
