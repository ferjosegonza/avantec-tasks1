<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Support\Facades\DB; // p/ trabajar con base de datos utilizando procedimientos almacenados
use Illuminate\Http\Request; // recuperar datos de la vista
use DataTables;


class TaskController extends Controller
{
    public function index(Request $request){

        if ($request->ajax()){
            $tasks = DB::select('CALL spsel_task()');
            return DataTables::of($tasks)
                ->addColumn('action', function ($tasks){
                    $acciones = '<a href="javascript:void(0)" onclick="editarTask('.$tasks->id.')" class="btn btn-info btn-sm">Editar</a>';
                    $acciones .= ' <button type="button" name="delete" id="'.$tasks->id.'" class="delete btn btn-danger btn-sm">Eliminar</button>';
                    return $acciones;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('task.index');
    }

    public function registrar(Request $request){
        // llamar al procedimiento almacenado para insertar un nuevo registro en la tabla Tasks
        $task = DB::select('CALL sp_insert_task(?, ?, ?, ?)',
                    [$request->user_id, $request->title, $request->description, $request->completed]);

        return back();
    }

    public function eliminar($id){
        $task = DB::select('CALL spdel_task(?)', [$id]);
        return back();
    }

    public function editar($id){
        $task = DB::select('CALL sp_seledit_task(?)', [$id]);
        return response()->json($task);
    }

    public function actualizar(Request $request){
        $task = DB::select('CALL sp_update_task(?, ?, ?, ?, ?)',
                    [$request->id,$request->user_id, $request->title, $request->description, $request->completed]);

        return back();
    }
}
