<?php

namespace App\Http\Controllers;

use App\Factor;
use Illuminate\Http\Request;
use Validator;

class FactorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Factor::orderBy('diferencia', 'asc')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->notDefined();
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

        $factor = Factor::create($request->all());

        return $factor;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Factor  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Factor::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Factor  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $this->notDefined();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Factor  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
           return response()->json($validator->errors(), 422);
        }

        $factor = Factor::findOrFail($id);

        $factor->fill($request->all());
        $factor->save();

        return $factor;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Factor  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $factor = Factor::findOrFail($id);
        $factor->delete();

        return $this->deleteMessage();
    }

    protected function rules()
    {
        return [
            'diferencia' => 'required|numeric',
            'factor' => 'required|numeric',
        ];
    }
}
