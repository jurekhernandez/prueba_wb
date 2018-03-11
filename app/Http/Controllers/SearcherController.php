<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Busqueda;
use App\Models\Productos;
class SearcherController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
   
    public function search(Request $request){
        if($request->isJson()){
            $data = $request->json()->all();
            $keyword=$data['keyword'];
            if($keyword != ""){
                $busqueda=$this->guardarBusqueda($keyword);
                $productos = \App\Models\Productos::where('tags','like',"%$keyword%")->get();
                foreach($productos as $producto){
                    $producto->busquedas()->attach($busqueda);
                }
                return response()->json([$productos], 200); 
            }
            return [];
        }
        return response()->json(['error' => 'Unauthorized'],401);
    }

    public function guardarBusqueda($keyword){
        $busqueda = new Busqueda;
        $busqueda->busqueda= $keyword;
        $busqueda->save();
        return $busqueda->id;
    }

    public function prueba(){
        $productos = \App\Models\Productos::get();
        return json_encode($productos);
    }

    public function estadistica(){
$productos = DB::table('producto_busqueda')->pluck('title', 'name')->get();

dd($productos);
        /*$productos = Productos::all();
       foreach($productos as $producto){
            echo"</br>**********</br>";
            print_r($producto);
            foreach($producto->busquedas as $bus){
                echo"</br>";
                print_r($bus);
            }
        }*/
    }
    /* 
select pb.id_producto, p.titulo, count(pb.id_producto) as 'cantidad' 
from  producto_busqueda pb
join productos p on pb.id_producto = p.id
group by pb.id_producto order 
by cantidad desc
limit 20;

*/

}
