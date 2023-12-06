<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Articulo;
use Cart;
use App\Models\Payment_Orders;
use Illuminate\Support\Str; // Se importó "Str" para generar un string aleatorio en la orden de compra ejecutada (Simulación)

class CartController extends Controller
{
    public function add(Request $request){

        $articulos = Articulo::find($request->id);
        if(empty($articulos))
            return redirect('cart/checkout');
        Cart::add(
            $articulos->id,
            $articulos->nombre,
            $request->qty ?? 1,
            $articulos->precio,
            ["img"=>$articulos->img]
            )->associate(Articulo::class);


        return redirect()->back()->with('success', 'Artículo agregado');
        


    }


    public function checkout(){
    foreach (Cart::content() as $item) {
        $articuloActualizado = Articulo::find($item->id);

        if ($articuloActualizado && ($articuloActualizado->precio != $item->price || $articuloActualizado->img != $item->options->img)) {
            // Actualizar el carrito
            Cart::update($item->rowId, [
                'price' => $articuloActualizado->precio,
                'options' => ['img' => $articuloActualizado->img]
            ]);

            // Opcional: Añadir mensaje para informar al usuario
            session()->flash('info', 'Algunos artículos en tu carrito han sido actualizados.');
        }
        }

        return view('cart.checkout');
    }




    public function removeItem(Request $request){

        Cart::remove($request->rowId);
        return redirect()->back()->with('success', 'Artículo eliminado');

    }


    public function clear(){

        Cart::destroy();
        return redirect()->back()->with('success', 'Carrito Vacio!');

    }


    public function updateItem(Request $request){
        $cartItem = Cart::get($request->rowId);
        $articulo = Articulo::find($cartItem->id);

        // Asegúrate de que la cantidad es mayor que cero
        if($request->qty <= 0){
        return redirect()->back()->with('error', 'La cantidad debe ser mayor a cero.');
        }
    
        if(!$articulo || $request->qty > $articulo->stock){
            return redirect()->back()->with('error', 'Cantidad no disponible. Stock máximo: ' . $articulo->stock);
        }
    
        Cart::update($request->rowId, $request->qty);
        return redirect()->back()->with('success', 'Cantidad actualizada');
    }


    

    public function payment(){

        // Verificación de stock para cada artículo en el carrito por si tiene cero stock que no permita avanzar con el pago y generacion de orden de compra.
        foreach (Cart::content() as $item) {
        $articulo = Articulo::find($item->id);
        if ($articulo->stock <= 0) {
            return redirect()->route('checkout')
                ->with('error', 'Uno o más artículos en tu carrito no tienen stock disponible.');
            }
        }


        $actualizado = false;
        foreach (Cart::content() as $item) {
            $articuloActualizado = Articulo::find($item->id);
            if ($articuloActualizado && ($articuloActualizado->precio != $item->price || $articuloActualizado->img != $item->options->img)) {
                Cart::update($item->rowId, [
                    'price' => $articuloActualizado->precio,
                    'options' => ['img' => $articuloActualizado->img]
                ]);
                $actualizado = true;
            }
        }
    
        if ($actualizado) {
            session()->flash('info', 'Algunos artículos en tu carrito han sido actualizados.');
        }

    
        return view('cart.payment');
    }




    public function processPayment(Request $request){

    // Verificar el stock de cada artículo en el carrito antes de procesar la compra, por si hay mas de un usuario en el momento queriendo comprar el mismo articulo y se queda sin stock
    foreach (Cart::content() as $item) {
        $articulo = Articulo::find($item->id);
        if ($item->qty > $articulo->stock || $articulo->stock <= 0) {
            // Redireccionar al carrito con un mensaje de error si el stock no es suficiente
            return redirect()->route('checkout')
                ->with('error', 'No hay suficiente stock para el producto: ' . $articulo->nombre);
        }
    }

    // Aquí va la lógica para procesar el pago y guardar la orden
    $validatedData = $request->validate([
        'nombre' => 'required|max:255',
        'apellido' => 'required|max:255',
        'dni' => 'required|numeric',
        'direccion' => 'required|max:255',
        'tarjeta' => 'required|numeric|digits:16',
        'codigo' => 'required|numeric|digits:3',
        'expiracion' => ['required', 'regex:/^(0[1-9]|1[0-2])\/?([0-9]{2})$/'],
        'email' => 'required|email',
    ], [
        'required' => 'El campo :attribute es obligatorio.',
        'nombre.required' => 'El nombre es obligatorio',
        'apellido.required' => 'El apellido es obligatorio',
        'dni.required' => 'El DNI es obligatorio',
        'direccion.required' => 'La dirección del domiciolio es obligatoria',
        'tarjeta.required' => 'El número de tarjeta es obligatorio',
        'codigo.required' => 'El codigo de la tarjeta es obligatorio',
        'expiracion.required' => 'El formato de la fecha de expiración debe ser MM/YY.',
        'email.required' => 'Debe tener formato de email',
    ]);

    // Procesa el pago aquí si la validación es exitosa
    // Redirige al usuario a una página de confirmación o similar


    // Crear un número de orden aleatorio y único
    $numeroOrden = Str::random(10);

    // Crear la orden
    $order = new Payment_Orders();
    $order->numero_orden = $numeroOrden;
    $order->nombre = $request->nombre;
    $order->apellido = $request->apellido;
    $order->dni = $request->dni;
    $order->direccion = $request->direccion;
    $order->email = $request->email;
    $order->numcard = $request->tarjeta;
    $order->save();

    // Actualizar el stock de cada artículo en el carrito
    foreach (Cart::content() as $item) {
        $articulo = Articulo::find($item->id);
        if ($articulo) {
            $articulo->stock = $articulo->stock - $item->qty; // Restar la cantidad comprada del stock existente
            $articulo->save();
            }
    }




    // Vaciar el carrito cuando se confirme el pago
    Cart::destroy();
    
    // Redirigir a una vista de confirmación con el número de orden
    return view('cart.paymentorders', compact('numeroOrden'));

    }
    
    
    





}
