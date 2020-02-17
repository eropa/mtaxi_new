<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Drive;
use App\Services\CarService;
use Illuminate\Http\Request;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Показываем предстовление
        return view('back.car.index',['datas'=>Car::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Показываем предстовления для добавления
        return view('back.car.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,CarService $carservice)
    {
        // создаем запись
        $carservice->create($request->all());
        // переходим к записям
        return redirect('upanel/car')->with('status', 'Вы создали запись!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function show(Car $car)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function edit(Car $car)
    {
        // показываем форму
        return view('back.car.edit',['data'=>$car]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Car $car,CarService $carservice)
    {
        // обновляем данные
        $carservice->update($car,$request->all());
        // переходим на список авто
        return redirect('upanel/car')->with('status', 'Вы обновили данные');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function destroy(Car $car)
    {
        // удоляем
        $car->delete();
        // переходим к списку
        return redirect('upanel/car')->with('status', 'Запись удалена');
    }
}
