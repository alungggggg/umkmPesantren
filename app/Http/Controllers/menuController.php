<?php

namespace App\Http\Controllers;

use App\Models\menuModel;
use App\Models\umkmModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use PDO;

class menuController extends Controller
{

    
    //
    public function get(){
        try{
            return response()->json(menuModel::all()->random(), 200);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Internal Server Error: ' . $e->getMessage() ,
            ], 500); 
        }
    }

    public function getMakan(){
        return response()->json(menuModel::where('category', 'makanan')->inRandomOrder()->get(), 200);
    }

    public function getMinum(){
        return response()->json(menuModel::where('category', 'minuman')->inRandomOrder()->get(), 200);
    }
    public function getJasa(){
        return response()->json(menuModel::where('category', 'jasa')->inRandomOrder()->get(), 200);
    }

    public function create(Request $request){
        try{
            $image = $request->file('image'); 
            $destinationPath = 'umkm/';
            $imageName = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $imageName);

            menuModel::create([
                "umkm_id" => $request->umkm_id,
                "namaMakanan" => $request->namaMakanan,
                "image" => $destinationPath . $imageName,
                "category" => $request->category,
                "harga" => $request->harga,
            ]);
            
            return response()->json(["message" => "menu successfully created"], 200);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Internal Server Error: ' . $e->getMessage() ,
            ], 500); 
        }
    }

    public function update($id, Request $request){
        try{
            $data = menuModel::find($id);
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
            $data->umkm_id = $request->umkm_id;
            $data->namaMakanan = $request->namaMakanan;
            $data->category = $request->category;
            $data->harga = $request->harga;

            $data->save();

            return response()->json(["message" => "menu successfully updated"]);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Internal Server Error: ' . $e->getMessage() ,
            ], 500); 
        }
    }

    public function delete(Request $request){
        try{
            $data = menuModel::find($request->id);

            if (File::exists($data['image'])) {
                File::delete($data['image']);
            }

            $data->delete();
            return response()->json(["message" => "menu successfully deleted"]);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Internal Server Error: ' . $e->getMessage() ,
            ], 500); 
        }
    }

    public function getById($id){
        try{
            $data = menuModel::find($id);
            if(!$data){
                return response()->json(["message" => "menu not found"], 404);
            }
            return response()->json($data, 200);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Internal Server Error: ' . $e->getMessage() ,
            ], 500); 
        }
    }
}
