<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Historiale extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['cantidad', 'id_bodega_origen', 'id_bodega_destino', 'id_inventario', 'created_by', 'updated_by'];
}
