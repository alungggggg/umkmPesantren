<?php

namespace App\Http\Controllers;

use App\Models\menuModel;
use App\Models\umkmModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class umkmController extends Controller
{

    public function getAllMakanan(){
        return response()->json(umkmModel::inRandomOrder()->where('category', 'makanan')->get()); 
    }

    public function getAllJasa(){
        return response()->json(umkmModel::inRandomOrder()->where('category', 'jasa')->get()); 
    }
    
    public function getAllMinuman(){
        return response()->json(umkmModel::inRandomOrder()->where('category', 'minuman')->get()); 
        
    }
    public function create(Request $request){
        try{

            $image = $request->file('image'); 
            $destinationPath = 'umkm/';
            $imageName = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $imageName);

            umkmModel::create([
                "namaUmkm" => $request->namaUmkm,
                "image" => $destinationPath . $imageName,
                "description" => $request->description,
                "category" => $request->category,
                "whatsapp" => $request->whatsapp,
                "maps" => $request->maps,
                "facebook" => $request->facebook,
                "instagram" => $request->instagram,
                "tiktok" => $request->tiktok
            ]);

            return response()->json(["status" => true, "message" => "umkm successfully created"]);
            
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Internal Server Error: ' . $e->getMessage() ,
            ], 500);    
        }
    }

    //
    public function get(){
        try{
            $data = umkmModel::all();
            return response()->json($data, 200);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Internal Server Error: ' . $e->getMessage() ,
            ], 500); 
        }
    }

    public function getById($id){ 
        try{
            $data = umkmModel::with('menu')->find($id);
            
            if(!$data){
                return response()->json(["message" => "UMKM not found"], 404);
            }
            
            return response()->json($data, 200);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Internal Server Error: ' . $e->getMessage() ,
            ], 500); 
        }
    }

    public function update(Request $request, $id)
    {
        try{
            $data = umkmModel::find($id);

            if($request->file('image')){
                if (File::exists($data['image'])) {
                    File::delete($data['image']);
                }
    
                $image = $request->file('image'); 
                $destinationPath = 'umkm/';
                $imageName = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $imageName);

                $data->image = $destinationPath . $imageName;
            }

            $data->namaUmkm = $request->namaUmkm;
            $data->description = $request->description;
            $data->category = $request->category;
            $data->whatsapp = $request->whatsapp;
            $data->maps = $request->maps;
            $data->facebook = $request->facebook;
            $data->instagram = $request->instagram;
            $data->tiktok = $request->tiktok;

            $data->save();

            return response()->json(["message" => "UMKM successfully updated"], 200);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Internal Server Error: ' . $e->getMessage() ,
            ], 500); 
        }
    }

    public function delete(Request $request){
        try{
            $data = umkmModel::find($request->id);
            if (File::exists($data['image'])) {
                File::delete($data['image']);
            }
            $data->delete();
            return response()->json(["message" => "UMKM successfully deleted"], 200);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Internal Server Error: ' . $e->getMessage() ,
            ], 500); 
        }
    }

    public function menuUmkm($id){
        try{
            return response()->json(umkmModel::with('menu')->find($id),200); 
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Internal Server Error: ' . $e->getMessage() ,
            ], 500); 
        }
        
    }
}
