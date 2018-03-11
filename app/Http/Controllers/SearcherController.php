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
        $productos = DB::select("select pb.id_producto, p.titulo, count(pb.id_producto) as 'cantidad' 
        from  producto_busqueda pb
        join productos p on pb.id_producto = p.id
        group by pb.id_producto order 
        by cantidad desc
        limit 20");
           for($i=0 ; $i<count($productos) ; $i++){
            $palabras= DB::select("
            select  pb.id_producto,b.busqueda, count(b.busqueda)as'cantidad'
            from producto_busqueda pb
            join busquedas b on pb.id_busqueda = b.id
            where pb.id_producto=?
            group by(b.busqueda)
            order by cantidad desc
            limit 5;",[$productos[$i]->id_producto]);

            $pal="(";
            foreach($palabras as $palabra){
                $pal.=$palabra->busqueda."(".$palabra->cantidad.")  ";
            }
            $pal.=")";
            $productos[$i]->palabras=$pal;
        }
        $productos=json_encode($productos);
        return $productos;
        
        
    }


}
