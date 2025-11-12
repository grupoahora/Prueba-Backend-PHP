<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bodega extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre',
        'id_responsable',
        'estado',
        'created_by',
        'updated_by'
    ];
}
