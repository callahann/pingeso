<?php

namespace App\Http\Controllers;

use App\Jerarquia;
use Illuminate\Http\Request;

class JerarquiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Jerarquia::all();
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Jerarquia  $jerarquia
     * @return \Illuminate\Http\Response
     */
    public function show(Jerarquia $jerarquia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Jerarquia  $jerarquia
     * @return \Illuminate\Http\Response
     */
    public function edit(Jerarquia $jerarquia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Jerarquia  $jerarquia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Jerarquia $jerarquia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Jerarquia  $jerarquia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jerarquia $jerarquia)
    {
        //
    }
}
