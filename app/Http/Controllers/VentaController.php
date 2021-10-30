<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Cart;

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
}
