<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Venta;
use Illuminate\Support\Facades\DB;
use Cart;
use Illuminate\Support\Str;
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
            array_push($label, $val->nombre.' | '.$val->descripcion);
        }
        return $label;
    }
    public function productos_proveedor(Request $request)
    {
        $productos = Producto::where('nombre', 'LIKE', '%' . $request->term . '%')
            ->where('proveedor', '=', $request->proveedor)
            ->orWhere('codigo_barras', 'LIKE', '%' . $request->term . '%')
            ->where('proveedor', '=', $request->proveedor)->get();
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
        $cadena = explode('|',$request->producto); 
        $producto = Producto::where('nombre', trim($cadena[0]))->where('descripcion',trim($cadena[1]))->first();
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
    public function checkout($valor)
    {
        if (number_format(floatval($valor),2) >= Cart::total()) {
            $cambio = $valor - Cart::total();
            $contenido_cart = Cart::content();
            $id_pedidos = '';
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
                $id_pedidos .= $pedido->id . '|';
                $producto = Producto::find($contenido->id);
                $stock = ($producto->stock - $pedido->cantidad);
                $producto->update([
                    'stock' => $stock
                ]);
            }
            $venta = Venta::create([
                'id_pedidos' => $id_pedidos,
                'cantidad_total' => Cart::count(),
                'subtotal' => Cart::subtotal(),
                'impuesto' => Cart::tax(),
                'total' => Cart::total(),
                'usuario' => Auth::user()->name,
            ]);
            $id_pedidos = str_replace('|', ',', $id_pedidos);
            $id_pedidos = substr($id_pedidos, 0, -1);
            DB::unprepared('update pedidos set id_venta = ' . $venta->id . ' where id in (' . $id_pedidos . ')');
            Cart::destroy();
            return $cambio;
        } else {
            $response = array(
                'error' => true,
                'message' => 'El valor ingresado es menor al total de la cuenta'
            );
            return $response;
        }
    }
    public function funcionesVentas(Request $request)
    {
        if ($request->funcion == 'editar_venta') {
            if ($request->cantidad != $request->cantidad_anterior && !empty($request->cantidad)) {
                $venta = DB::table('pedidos')->where('id', '=', $request->id_venta)->first();
                $producto = DB::table('productos')->where('id', '=', $venta->id_producto)->first();
                DB::table('pedidos')->where('id', '=', $request->id_venta)->update([
                    'cantidad' => $request->cantidad,
                    'total' => ($request->cantidad * $venta->precio),
                ]);
                DB::table('productos')->where('id', '=', $venta->id_producto)->update([
                    'stock' => $producto->stock - ($request->cantidad - $request->cantidad_anterior)
                ]);
                $venta_final = DB::table('pedidos')->where('id_venta', '=', $venta->id_venta)->get();
                $cantidad = 0;
                $total = 0;
                foreach ($venta_final as $val) {
                    $cantidad += $val->cantidad;
                    $total += $val->total;
                }
                DB::table('ventas')->where('id', '=', $venta->id_venta)->update([
                    'cantidad_total' => $cantidad,
                    'subtotal' => $total,
                    'total' => $total,
                ]);
                $response = array(
                    'response' => 'success',
                    'message' => 'Venta Actualizada correctamente'
                );
            } else {
                $response = array(
                    'response' => 'error',
                    'message' => 'Ingrese una cantidad correcta para poder editar '
                );
            }
            return $response;
        }
        if ($request->funcion == 'eliminar_venta') {
            $venta = DB::table('pedidos')->where('id', '=', $request->id_venta)->first();
            $producto = DB::table('productos')->where('id', '=', $venta->id_producto)->first();
            DB::table('pedidos')->where('id', '=', $request->id_venta)->delete();
            DB::table('productos')->where('id', '=', $venta->id_producto)->update([
                'stock' => ($producto->stock + $request->cantidad)
            ]);
            $venta_final = DB::table('pedidos')->where('id_venta', '=', $venta->id_venta)->get();
            $cantidad = 0;
            $total = 0;
            foreach ($venta_final as $val) {
                $cantidad += $val->cantidad;
                $total += $val->total;
            }
            DB::table('ventas')->where('id', '=', $venta->id_venta)->update([
                'cantidad_total' => $cantidad,
                'subtotal' => $total,
                'total' => $total,
            ]);
            if ($cantidad == 0 && $total == 0) {
                DB::table('ventas')->where('id', '=', $venta->id_venta)->delete();
            }
            $response = array(
                'response' => 'success',
                'message' => 'Venta eliminada correctamente',
            );
            return $response;
        }
        if ($request->funcion == 'eliminar_venta_total') {
            $pedidos = DB::table('pedidos')->where('id_venta', '=', $request->id_venta)->get();
            foreach ($pedidos as $value) {
                $producto = DB::table('productos')->where('id', '=', $value->id_producto)->first();
                DB::table('productos')->where('id', '=', $value->id_producto)->update([
                    'stock' => ($producto->stock + $value->cantidad)
                ]);
            }
            DB::table('ventas')->where('id', '=', $request->id_venta)->delete();
            DB::table('pedidos')->where('id_venta', '=', $request->id_venta)->delete();
        }
    }
    public function token_eliminar(Request $request){

        $token = User::where('toke_eliminar','=',$request->token)->get();
        if($token->count()>0){
             $response = ['response'=>'correcto'];
             User::where('id','=',$token[0]->id)->update([
                 'toke_eliminar'=> Str::random(10)
             ]);
        }else {
            $response = ['response'=>'error'];
        }
        return $response;
    }
    public function listar_pedidos(Request $request){
        $pedidos = DB::table('pedidos')->join('productos','productos.id','=','pedidos.id_producto')->select('pedidos.*','productos.nombre')->where('id_venta', '=', $request->id_pedido)->get();
        $json = [];
        foreach ($pedidos as $value) {
            array_push($json,$value);
        }
        return $json;
    }
}
