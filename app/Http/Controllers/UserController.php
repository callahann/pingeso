<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Departamento;
use App\Jerarquia;
use App\Jornada;
use App\Rol;
use Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->rol == 1) {
            return User::where('id_departamento', Auth::user()->id_departamento)
                        ->get()
                        ->load('departamento.facultad');
        } else return User::all()->load('departamento.facultad');
    }

    public function indexComision($tipo_usuario, $id_entidad, $tipo_entidad)
    {

        if($tipo_usuario == 0 or $tipo_usuario == 1){
            if ($tipo_entidad == 0) {
                return User::whereNull('id_comision')
                    ->get()
                    ->load('departamento.facultad');                    
            }
            elseif($tipo_entidad == 1){
                return User::whereNull('id_comision')
                    ->whereHas('departamento', function($q) use($id_entidad){
                    $q->where('id_facultad', $id_entidad);})
                    ->get()
                    ->load('departamento.facultad');   
            }
            else{
                return User::whereNull('id_comision')
                    ->where('id_departamento', $id_entidad)
                    ->get()
                    ->load('departamento.facultad'); 
            }
        }
        else{
            if ($tipo_entidad == 0) {
                return User::whereNull('id_comision')
                    ->get()
                    ->load('departamento.facultad');                    
            }
            elseif($tipo_entidad == 1){
                return User::whereNull('id_comision')
                    ->whereHas('departamento', function($q) use($id_entidad){
                    $q->where('id_facultad', '!=', $id_entidad);})
                    ->get()
                    ->load('departamento.facultad');   
            }
            else{
                return User::whereNull('id_comision')
                    ->where('id_departamento', '!=', $id_entidad)
                    ->get()
                    ->load('departamento.facultad'); 
            }
        }
        
    }

    public function show($id){  
        return User::where('id', $id)   
                ->first();  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
           return response()->json($validator->errors(), 422);
        }

        $user = new User($request->all());
        $user->id_comision = $request->comision['id'];
        $user->id_departamento = $request->departamento['id'];
        $user->id_jerarquia = $request->jerarquia['id'];
        $user->id_jornada = $request->jornada['id'];
        $user->id_rol = $request->rol['id'];
        $user->save();
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->rules($id));

        if ($validator->fails()) {
           return response()->json($validator->errors(), 422);
        }

        $user = User::find($id);
        $user->fill($request->all());
        $user->id_comision = $request->id_comision;
        $user->rol_comision = $request->rol_comision;
        $user->id_departamento = $request->departamento['id'];
        $user->id_jerarquia = $request->jerarquia['id'];
        $user->id_jornada = $request->jornada['id'];
        $user->rol = $request->rol;
        $user->save();

        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return $this->deleteMessage();
    }

    protected function rules($id)
    {
        if($id) {
            return [
                'apellido_paterno' => 'required',
                'apellido_materno' => 'required',
                'nombres' => 'required',
                'departamento' => 'required',
                'jerarquia' => 'required',
                'jornada' => 'required',
                'rol' => 'required',
                'email' => 'required|unique:users,email,' . $id,
            ];
        }
        return [
            'apellido_paterno' => 'required',
            'apellido_materno' => 'required',
            'nombres' => 'required',
            'departamento' => 'required',
            'jerarquia' => 'required',
            'jornada' => 'required',
            'rol' => 'required',
            'email' => 'required|unique:users,email',
        ];
    }   
}
