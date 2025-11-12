<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{
    public function indexTotalDesc()
    {
        $productos = DB::table('productos')
            ->select('productos.id', 'productos.nombre', 'productos.descripcion', 'productos.estado', DB::raw('SUM(inventarios.cantidad) as total'))
            ->leftJoin('inventarios', 'productos.id', '=', 'inventarios.id_producto')
            ->leftJoin('bodegas', 'inventarios.id_bodega', '=', 'bodegas.id')
            ->where('productos.estado', 1)
            ->where('bodegas.estado', 1)
            ->groupBy('productos.id', 'productos.nombre', 'productos.descripcion', 'productos.estado')
            ->orderBy('total', 'desc')
            ->get();

        return response()->json($productos);
    }
}