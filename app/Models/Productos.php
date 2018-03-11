<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Productos extends Model{

    protected $table="productos";
    protected $primaryKey ="id";
    protected $fillable=['titulo','descripcion','fecha_inicio','fecha_termino','precio','imagen','vendidos','tags'];
    public $timestamps = false;


    public function busquedas(){
       return $this->belongsToMany('\App\Models\Busqueda','producto_busqueda','id_producto','id_busqueda');
    }


}