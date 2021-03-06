<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\PupukModel;

class PupukController extends Controller
{
    public function pupuk(){
        return response()->json(PupukModel::get(),200);
    }
    public function organik(){
        $pupuk = PupukModel::where(['jenis_pupuk'=>'organik'])->get();
        return response()->json([
            'success'=> true,
            'pupuk'=>$pupuk
        ]);
    }
    public function anorganik(){
        $pupuk = PupukModel::where(['jenis_pupuk'=>'anorganik'])->get();
        return response()->json([
            'success'=> true,
            'pupuk'=>$pupuk
        ]);    }
    
    public function pupukByID ($pupuk_id){
        return response()->json(PupukModel::find($pupuk_id),200);
    }
    public function pupukUpdate(Request $request){
        $pupuk = PupukModel::find($request->id);
        $pupuk->harga_pupuk = $request->harga_pupuk;
        $pupuk->update();
        return response()->json([
            'success' => true,
            'message' => 'pupuk updated'
        ]);    }
    public function pupukSave(Request $request){
        $pupuk = new PupukModel;
        $pupuk->nama_pupuk = $request->nama_pupuk; 
        $pupuk->jenis_pupuk = $request->jenis_pupuk; 
        $pupuk->deskripsi_pupuk = $request->deskripsi_pupuk; 
        $pupuk->komposisi_pupuk = $request->komposisi_pupuk; 
        $pupuk->harga_pupuk = $request->harga_pupuk; 
        if($request->hasFile('foto_pupuk')){
            $file = $request->file('foto_pupuk');
            $extenstion = $file->getClientOriginalExtension();
            $foto = time().'.'.$extenstion;
            $file->move('storage/pupuk',$foto);
            $pupuk->foto_pupuk = $foto;
        }else{
            return $request;
            $pupuk->foto_pupuk ='';
        }
        $pupuk->save();
        return response()->json([
            'success'=>true,
            'pupuk'=>$pupuk
        ]);

    }
    public function pupukDelete(Request $request){
        $pupuk = PupukModel::find($request->id);
        $pupuk->delete();
        return response()->json([
            'success' => true,
            'message' => 'pupuk deleted'
        ]);
    }}
