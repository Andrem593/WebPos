<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class compra extends Model
{
    static $rules = [
		'cantidad' => 'required',
    'total_factura' => 'required',
    'costo' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['numero_factura','id_proveedor','id_producto','cantidad','total_factura','costo'];

}
