<?php

namespace App\Http\Livewire;

use Livewire\Component;

class TablaPedidos extends Component
{
    protected $listeners = ['render2' => 'render'];
    
    public function render()
    {
        return view('livewire.tabla-pedidos');
    }
}
