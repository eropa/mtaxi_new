<?php

namespace App\Http\Controllers;

use App\Models\Cotrudnik;
use Illuminate\Http\Request;
use App\Services\CotrudnikService;

class CotrudnikController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('back.contrudnik.index',['datas'=>Cotrudnik::all()]);
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
     * @param  \App\Models\Cotrudnik  $cotrudnik
     * @return \Illuminate\Http\Response
     */
    public function show(Cotrudnik $cotrudnik)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cotrudnik  $cotrudnik
     * @return \Illuminate\Http\Response
     */
    public function edit(Cotrudnik $cotrudnik)
    {
        //Показываем предстовление , изменяем данные сотрудника
        return view('back.contrudnik.edit',['data'=>$cotrudnik]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cotrudnik  $cotrudnik
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cotrudnik $cotrudnik,CotrudnikService $cotrudnikservice)
    {
        // Обновляем данные
        $cotrudnikservice->update($cotrudnik,$request->all());
        //
        return redirect('upanel/cotrudnik')->with('status', 'Вы обновили данные');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cotrudnik  $cotrudnik
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cotrudnik $cotrudnik)
    {
        //
    }
}
