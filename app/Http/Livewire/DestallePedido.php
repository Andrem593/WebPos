<?php

namespace App\Http\Livewire;

use Livewire\Component;

class DestallePedido extends Component
{
    protected $listeners = ['render' => 'render'];

    public function render()
    {
        return view('livewire.destalle-pedido');
    }
}
