<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        return User::all()->load(['departamento.facultad', 'jerarquia', 'jornada', 'rol']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $user->id_departamento = $request->departamento['id'];
        $user->id_jerarquia = $request->jerarquia['id'];
        $user->id_jornada = $request->jornada['id'];
        $user->id_rol = $request->rol['id'];
        $user->save();
        return $this->creationMessage();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return User::find($id)->load(['departamento.facultad', 'jerarquia', 'jornada', 'rol']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $user->id_departamento = $request->departamento['id'];
        $user->id_jerarquia = $request->jerarquia['id'];
        $user->id_jornada = $request->jornada['id'];
        $user->id_rol = $request->rol['id'];
        $user->save();

        return $this->creationMessage();
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
