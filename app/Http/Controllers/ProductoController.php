<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class ProductoController
 * @package App\Http\Controllers
 */
class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productos = DB::table('productos')
            ->join('categorias', 'categorias.id', '=', 'productos.categoria')
            ->join('proveedores', 'proveedores.id', '=', 'productos.proveedor')
            ->select('productos.*', 'categorias.nombre as nombre_categoria', 'proveedores.nombre as nombre_proveedor')
            ->get();
        return view('producto.index', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $producto = new Producto();
        return view('producto.create', compact('producto'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Producto::$rules);

        $categoria_id = DB::table('categorias')->where('nombre', 'like', '%' . strtoupper(trim($request->nombre_categoria))  . '%')->value('id');

        if (empty($categoria_id)) {
            $categoria_id = DB::table('categorias')->insertGetId(
                array('nombre' => strtoupper(trim($request->nombre_categoria)), 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'))
            );
        }

        $proveedor_id = DB::table('proveedores')->where('nombre', 'like', '%' . strtoupper(trim($request->nombre_proveedor)) . '%')->value('id');

        if (empty($proveedor_id)) {
            $proveedor_id = DB::table('proveedores')->insertGetId(
                array('nombre' => strtoupper(trim($request->nombre_proveedor)), 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'))
            );
        }
        $request['categoria'] = $categoria_id;
        $request['proveedor'] = $proveedor_id;
        $request['nombre'] = strtoupper(trim($request->nombre));
        $request['descripcion']  = strtoupper(trim($request->descripcion)); 
        $producto = Producto::create($request->all());

        return redirect()->route('productos.index')
             ->with('success', 'Producto Creado correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $producto = Producto::find($id);

        return view('producto.show', compact('producto'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $producto = Producto::find($id);

        return view('producto.edit', compact('producto'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Producto $producto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Producto $producto)
    {
        request()->validate(Producto::$rules);

        $producto->update($request->all());

        return redirect()->route('productos.index')
            ->with('success', 'Producto Actualizado correctamente');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $producto = Producto::find($id)->delete();

        return redirect()->route('productos.index')
            ->with('success', 'Producto Eliminado correctamente');
    }
    public function productoUpload()
    {
        return view('producto.upload');
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

                $categoria_id = DB::table('categorias')->where('nombre', 'like', '%' . strtoupper(trim($row[7]))  . '%')->value('id');

                if (empty($categoria_id)) {
                    $categoria_id = DB::table('categorias')->insertGetId(
                        array('nombre' => strtoupper(trim($row[7])), 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'))
                    );
                }

                $proveedor_id = DB::table('proveedores')->where('nombre', 'like', '%' . strtoupper(trim($row[8])) . '%')->value('id');

                if (empty($proveedor_id)) {
                    $proveedor_id = DB::table('proveedores')->insertGetId(
                        array('nombre' => strtoupper(trim($row[8])), 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'))
                    );
                }
                $insert_data = array(
                    'codigo_barras'  => $row[0],
                    'nombre'  => strtoupper(trim($row[1])),
                    'descripcion'  => $row[2],
                    'cantidad'  => $row[3],
                    'stock'  =>  $row[3],
                    'unidad_medida'  => strtoupper(trim($row[4])),
                    'medida'  => $row[5],
                    'precio' => $row[6],
                    'categoria' => $categoria_id,
                    'proveedor' => $proveedor_id,
                    'costo_proveedor' => $row[9]

                );
                Producto::create($insert_data);
            }
        }

        return redirect()->route('productos.index')
            ->with('success', 'Productos cargados correctamente');
    }
}
