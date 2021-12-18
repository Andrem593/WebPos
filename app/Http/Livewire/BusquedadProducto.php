<?php

namespace App\Http\Livewire;

use App\Models\caja;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class BusquedadProducto extends Component
{
    public $valorInicio = 0;
    public $ventas;
    public function render()
    {
        $caja = caja::where('created_at','LIKE','%'.date('Y-m-d').'%')->first();
        if (!empty($caja) ) {
            $this->valorInicio = $caja->valor_inicio;
        }
        $ventas = DB::table('ventas')->where('created_at', 'like', '%' . date('Y-m-d') . '%')->get();
        $ventas_dia = 0;
        foreach ($ventas as $venta) {
            $ventas_dia += $venta->total;
        }
        $this->ventas = $ventas_dia; 
        return view('livewire.busquedad-producto');
    }
    public function inicio_caja(){
        caja::create([
            'valor_inicio'=> $this->valorInicio,
            'vendedor'=> Auth::user()->name,
        ]);
    }
    public function cerrar_caja(){
        caja::orderBy('id','desc')->first()->update([
            'faturacion_dia'=> $this->ventas,
            'total_caja'=> ($this->ventas+$this->valorInicio),
        ]);
    }

}
