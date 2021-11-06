<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Producto;
use Illuminate\Http\Request;
use App\Models\Venta;
use Cart;
use Illuminate\Support\Facades\Auth;

class VentaController extends Controller
{
    public function index()
    {
        return view('pedido.index');
    }
    public function autocomplete(Request $request)
    {
        $productos = Producto::where('nombre', 'LIKE', '%' . $request->term . '%')
            ->orWhere('codigo_barras', 'LIKE', '%' . $request->term . '%')->get();
        $label = [];
        foreach ($productos as $val) {
            array_push($label, $val->nombre);
        }
        return $label;
    }
    public function productos_proveedor(Request $request)
    {
        $productos = Producto::where('nombre', 'LIKE', '%' . $request->term . '%')
            ->where('proveedor','=',$request->proveedor)
            ->orWhere('codigo_barras', 'LIKE', '%' . $request->term . '%')
            ->where('proveedor','=',$request->proveedor)->get();
        $label = [];
        foreach ($productos as $val) {
            array_push($label, $val->nombre);
        }
        return $label;
    }
    public function store(Request $request)
    {
        if (empty($request['cantidad'])) {
            $request['cantidad'] = 1;
        }
        $producto = Producto::where('nombre', trim($request->producto))->first();
        if (empty($producto)) {
            $producto = Producto::where('codigo_barras', trim($request->producto))->first();
        }
        $cart = Cart::add(['id' => $producto->id, 'name' => $producto->nombre, 'qty' => $request['cantidad'], 'price' => $producto->precio, 'weight' => 0, 'options' => ['codigo_barras' => $producto->codigo_barras]]);
        return 'add';
    }
    public function destroy($rowId)
    {
        Cart::remove($rowId);
        return view('pedido.index');
    }
    public function destroyAll()
    {
        Cart::destroy();
        return view('pedido.index');
    }
    public function edit($rowId)
    {
        Cart::update($rowId, $_POST['cantidad']); 
    }
    public function checkout($valor){
        $cambio = $valor - Cart::total();
        $contenido_cart = Cart::content(); 
        $id_pedidos= '';
        foreach ($contenido_cart as $contenido) {
            $total = ($contenido->price * $contenido->qty);
            $codigo_barras = $contenido->options->codigo_barras;
            if (empty($codigo_barras)) {
                $codigo_barras = '';
            }
            $pedido = Pedido::create([
                'id_producto' => $contenido->id,
                'codigo_barras' => $codigo_barras,
                'cantidad' => $contenido->qty,
                'precio' => $contenido->price,
                'total' => $total
            ]);
            $id_pedidos .= $pedido->id.'|'; 
            $producto = Producto::find($contenido->id);
            $stock = ($producto->stock - $pedido->cantidad);
            $producto->update([
                'stock'=> $stock
            ]);
        }
        Venta::create([
            'id_pedidos' => $id_pedidos ,
            'cantidad_total' => Cart::count(),
            'subtotal' => Cart::subtotal(),
            'impuesto' => Cart::tax(),
            'total' => Cart::total(),
            'usuario' => Auth::user()->name,
        ]);
        Cart::destroy();
        return $cambio;
    }
}
