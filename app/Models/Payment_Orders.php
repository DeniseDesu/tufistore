<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categoria;
use App\Models\Articulo;
use App\Models\Tienda;

class Payment_Orders extends Model
{
    use HasFactory;

    protected $table = 'payment_orders';

    protected $fillable = ['nombre', 'apellido', 'dni', 'direccion', 'email', 'numcard'];

}
