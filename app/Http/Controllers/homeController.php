<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class homeController extends Controller
{
    public function index(){
        $pedidos = DB::table('pedidos')->where('created_at','like','%'.date('Y-m-d').'%')->get();
        $producto = DB::table('pedidos')->join('productos','productos.id','=','pedidos.id_producto')
        ->select(DB::raw('count(pedidos.id) as num_pedido, pedidos.id_producto,productos.nombre'))
        ->where('pedidos.created_at','like','%'.date('Y-m-d').'%')
        ->groupBy('id_producto')
        ->orderBy('num_pedido','desc')
        ->first();
        $pedidos_mes = DB::table('pedidos')->where('created_at','like','%'.date('Y-m').'%')->get();
        $ventas = 0;
        foreach ($pedidos as $pedido) {
           $ventas = $ventas + $pedido->total;
        }
        $ventas_mes = 0;
        foreach ($pedidos_mes as $pedido) {
            $ventas_mes = $ventas_mes + $pedido->total;
        }
        return view('dashboard',compact('pedidos','producto','ventas','ventas_mes'));
    }
}
