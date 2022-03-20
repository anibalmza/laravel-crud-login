<?php

namespace App\Http\Controllers;

use App\Models\empleado;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datos['empleados']=empleado::paginate(3);
        return view('empleado.index', $datos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('empleado.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $campos=[               // campos a validar
            'apellido'=>'required|string|max:100',
            'nombre'=>'required|string|max:100',
            'email'=>'required|email',
            'foto'=>'required|max:10000|mimes:jpeg,jpg,png',
        ];

        $mensajes=[             // mensajes de error
            'required'=>'El :attribute es requerido',
            'foto.required'=>'La foto es requerida'
        ];

        $this->validate($request, $campos, $mensajes);

        // $datosEmpleado = request()->all();
        $datosEmpleado = request()->except('_token');

        if($request->hasFile('foto')){
            $datosEmpleado['foto']=$request->file('foto')->store('uploads','public');
        }

        Empleado::insert($datosEmpleado);
        
        // return response()->json($datosEmpleado);
        // return redirect('/empleado');
        return redirect('/empleado')->with('mensaje','Empleado Creado');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function show(empleado $empleado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $empleado=empleado::findOrFail($id);
        return view('empleado.edit', compact('empleado'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $campos=[               // campos a validar
            'apellido'=>'required|string|max:100',
            'nombre'=>'required|string|max:100',
            'email'=>'required|email',
            // 'foto'=>'required|max:10000|mimes:jpeg,jpg,png',
        ];

        $mensajes=[             // mensajes de error
            'required'=>'El :attribute es requerido',
            // 'foto.required'=>'La foto es requerida'
        ];

        if($request->hasFile('foto')){
            $campos=['foto'=>'required|max:10000|mimes:jpeg,jpg,png'];
            $mensajes=['foto.required'=>'La foto es requerida'];
        }
        $this->validate($request, $campos, $mensajes);

        $datosEmpleado = request()->except(['_token','_method']);

        if($request->hasFile('foto')){
            $empleado=empleado::findOrFail($id);

            Storage::delete('public/'.$empleado->foto);
            
            $datosEmpleado['foto']=$request->file('foto')->store('uploads','public');
        }

        empleado::where('id','=', $id)->update($datosEmpleado);

        
        $empleado=empleado::findOrFail($id);
        // return view('empleado.edit', compact('empleado'));

        return redirect('/empleado')->with('mensaje','Empleado Actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $empleado=empleado::findOrFail($id);

        if(Storage::delete('public/'.$empleado->foto)){
            
            empleado::destroy($id);

        };
        
        return redirect('/empleado')->with('mensaje','Empleado Eliminado');
    }
}
