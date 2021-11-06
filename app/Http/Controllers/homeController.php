<?php

namespace App\Http\Controllers;

use App\Models\compra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class homeController extends Controller
{
    public function index()
    {
        $pedidos = DB::table('pedidos')->where('created_at', 'like', '%' . date('Y-m-d') . '%')->get();
        $producto = DB::table('pedidos')->join('productos', 'productos.id', '=', 'pedidos.id_producto')
            ->select(DB::raw('count(pedidos.id) as num_pedido, pedidos.id_producto,productos.nombre'))
            ->where('pedidos.created_at', 'like', '%' . date('Y-m-d') . '%')
            ->groupBy('id_producto')
            ->orderBy('num_pedido', 'desc')
            ->first();
        $pedidos_mes = DB::table('pedidos')->where('created_at', 'like', '%' . date('Y-m') . '%')->get();
        $ventas = 0;
        foreach ($pedidos as $pedido) {
            $ventas = $ventas + $pedido->total;
        }
        $ventas_mes = 0;
        foreach ($pedidos_mes as $pedido) {
            $ventas_mes = $ventas_mes + $pedido->total;
        }
        $semana = date("Y-m-d", strtotime(date('d-m-Y') . "- 7 days"));
        $semana_actual = DB::table('ventas')->where('created_at', '>=', $semana)->get();
        $semana_pasada = date("Y-m-d", strtotime(date('d-m-Y') . "- 14 days"));
        $data_semana_pasada = DB::table('ventas')->where('created_at', '>=', $semana_pasada)->where('created_at', '<', $semana)->get();
        $productos_vendidos = 0;
        $productos_vendidos_sp = 0;
        foreach ($semana_actual as $val) {
            $productos_vendidos = $val->cantidad_total + $productos_vendidos;
        }
        foreach ($data_semana_pasada as $val) {
            $productos_vendidos_sp = $val->cantidad_total + $productos_vendidos_sp;
        }
        $incremento = $productos_vendidos_sp > 0 ? number_format(((($productos_vendidos - $productos_vendidos_sp) / $productos_vendidos_sp) * 100), 2) : 100;
        return view('dashboard', compact('pedidos', 'producto', 'ventas', 'ventas_mes', 'productos_vendidos', 'incremento'));
    }
    public function reporte_ventas()
    {
        $ventas = DB::table('pedidos')
            ->join('productos', 'productos.id', '=', 'pedidos.id_producto')
            ->join('categorias','categorias.id','=','productos.categoria')
            ->select('pedidos.*', 'productos.nombre as nombre_producto',  'productos.costo_proveedor', 'productos.codigo_barras', 'categorias.nombre as nombre_categoria')           
            ->get();
        return view('reportes.ventas',compact('ventas'));
    }
    public function reporte_compras(Request $request)
    {
        $compras = DB::table('compras')->join('proveedores', 'proveedores.id', '=', 'compras.id_proveedor')
            ->join('productos', 'productos.id', '=', 'compras.id_producto')
            ->select('compras.*', 'productos.nombre as nombre_producto', 'proveedores.nombre as nombre_proveedor', 'proveedores.ruc as ruc_proveedor', 'productos.costo_proveedor', 'productos.codigo_barras')           
            ->get();
        if (!empty($request->desde)) {
            $desde = $request->desde;
            $hasta = date("Y-m-d", strtotime($request->hasta . "+ 1 days"));
            $compras = DB::table('compras')->join('proveedores', 'proveedores.id', '=', 'compras.id_proveedor')
                ->join('productos', 'productos.id', '=', 'compras.id_producto')
                ->select('compras.*', 'productos.nombre as nombre_producto', 'proveedores.nombre as nombre_proveedor', 'proveedores.ruc as ruc_proveedor', 'productos.costo_proveedor', 'productos.codigo_barras')
                ->where('compras.created_at', '>=', $desde)->where('compras.created_at', '<', $hasta)
                ->get();
        }
        return view('reportes.compras', compact('compras'));
    }
    public function inventario()
    {
        return view('reportes.inventario');
    }
}
