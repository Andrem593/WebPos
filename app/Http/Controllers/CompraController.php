<?php

namespace App\Http\Controllers;

use App\Models\compra;
use App\Models\Proveedore;
use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;

class CompraController extends Controller
{
    public function index()
    {
        return view('compras.upload');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $compra = new Compra();
        $proveedores = Proveedore::all();
        return view('compras.create', compact('compra', 'proveedores'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'id_proveedor' => 'required',
            'nombre_producto' => 'required|min:1',
            'id_proveedor' => 'required',
            'cantidad' => 'required',
            'total_factura' => 'required',
        ]);
        $producto = Producto::where('nombre', trim($request->nombre_producto))->first();
        if (empty($producto)) {
            $producto = Producto::where('codigo_barras', trim($request->nombre_producto))->first();
        }
        if (empty($producto)) {
            return redirect()->route('compras.create')
                ->with('error', 'Escoga un producto valido.');
        }
        $request['id_producto'] = $producto->id;
        $producto->stock = $producto->stock + $request->cantidad;
        $producto->cantidad = $producto->cantidad + $request->cantidad;
        $producto->costo_proveedor = $request->costo;
        $producto->save();
        $compras = Compra::create($request->all());
        return redirect()->route('compras.create')
            ->with('success', 'Compra registrada correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function saveExcel(Request $request)
    {
        $request->validate([
            'excel' => 'required|max:10000|mimes:xlsx,xls'
        ]);

        $file_array = explode(".", $_FILES["excel"]["name"]);
        $file_extension = end($file_array);

        $file_name = time() . '.' . $file_extension;
        move_uploaded_file($_FILES["excel"]["tmp_name"], $file_name);
        $file_type = \PhpOffice\PhpSpreadsheet\IOFactory::identify($file_name);
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($file_type);

        $spreadsheet = $reader->load($file_name);

        unlink($file_name);

        $data = $spreadsheet->getActiveSheet()->toArray();

        foreach ($data as $key => $row) {
            if ($key >= 1) {

                $producto_id = DB::table('productos')->where('nombre', 'like', '%' . strtoupper(trim($row[4]))  . '%')->value('id');

                if (empty($producto_id)) {
                    $producto_id = DB::table('productos')->where('codigo_barras', 'like', '%' . strtoupper(trim($row[3]))  . '%')->value('id');
                }

                $proveedor_id = DB::table('proveedores')->where('nombre', 'like', '%' . strtoupper(trim($row[2])) . '%')->value('id');

                if (empty($proveedor_id)) {
                    $proveedor_id = DB::table('proveedores')->where('ruc', 'like', '%' . strtoupper(trim($row[1])) . '%')->value('id');
                }
                $insert_data = array(
                    'numero_factura'  => $row[0],
                    'id_proveedor' => $proveedor_id,
                    'id_producto' => $producto_id,
                    'cantidad'  => $row[5],
                    'costo'  => $row[6],
                    'total_factura'  => $row[7],
                );
                compra::create($insert_data);
                $producto = Producto::find($producto_id);
                $producto->stock = $producto->stock + $row[5];
                $producto->cantidad = $producto->cantidad + $row[5];
                $producto->costo_proveedor = $row[6];
                $producto->save();
            }
        }

        return redirect()->route('compras.index')
            ->with('success', 'Compras cargadas correctamente');
    }
}
