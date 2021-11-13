<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class caja extends Model
{
    use HasFactory;

    protected $fillable = ['valor_inicio','faturacion_dia','total_caja','vendedor'];

}
