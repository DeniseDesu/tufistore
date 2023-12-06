<?php

namespace App\Models;

use App\Models\Tienda;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categoria;

class Articulo extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'categoria', 'stock', 'precio', 'img', 'is_visible', 'categoria_id'];


//Se importe el modelo Categoria y luego se creo una funcion para hacer un joineo de tablas con Articulo para que no figure el numero de ID, sino el nombre de la categoria

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');

    }


}
