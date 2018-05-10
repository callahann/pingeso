<?php

namespace App\Http\Controllers;

use App\Formula;
use Illuminate\Http\Request;

class FormulaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Formula::paginate();
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

        $data = $request->validate([
            'nombre' => 'required',
            'detalle' => 'required',
        ]);

        $formula = Formula::create($data);

        return $this->creationMessage();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Formula  $formula
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $formula = Formula::findOrFail($id);
        return $formula;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Formula  $formula
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $formula = Formula::findOrFail($id);
        return $this->notDefined();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Formula  $formula
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $formula = Formula::findOrFail($id);
        $data = $request->validate([
            'nombre' => 'required',
            'detalle' => 'required',
        ]);

        $formula->fill($data);
        $formula->save();

        return $this->updateMessage();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Formula  $formula
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $formula = Formula::findOrFail($id);
        $formula->delete();

        return $this->deletedMessage();
    }
}
