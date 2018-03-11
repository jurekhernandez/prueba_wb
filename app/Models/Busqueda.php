<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Busqueda extends Model{

    protected $table="busquedas";
    protected $primaryKey ="id";
    protected $fillable=["busqueda"];
    public $timestamps = false;


    public function productos(){
       return $this->belongsToMany('\App\Models\Productos','producto_busqueda','id_busqueda','id_producto');
    }

}