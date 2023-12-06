<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Articulo;
use App\Models\Tienda;

class Categoria extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'is_visible'];

    //Se importe el modelo Categoria y luego se creo una funcion para hacer un joineo de tablas con Articulo para que no figure el numero de ID, sino el nombre de la categoria

    public function articulos()
    {
        return $this->hasMany(Articulo::class, 'categoria_id', 'id');

    }



}
