<?php

namespace App\Http\Controllers;

use App\Models\Firma;
use App\Services\CarService;
use App\Services\FirmaService;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\Object_;

class FirmaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('back.firma.index',['datas'=>Firma::all()]);
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back.firma.create');
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,FirmaService $firmaservice)
    {
        // добовляем данные
        $firmaservice->create($request->all());
        // переходим на новую запись
        return redirect('upanel/firma')->with('status', 'Вы добавили данные');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Firma  $firma
     * @return \Illuminate\Http\Response
     */
    public function show(Firma $firma)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Firma  $firma
     * @return \Illuminate\Http\Response
     */
    public function edit(Firma $firma)
    {
        //
        return view('back.firma.edit',['data'=>$firma]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Firma  $firma
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Firma $firma,FirmaService $firmaservice)
    {
        $firmaservice->update($firma,$request->all());
        return redirect('upanel/firma')->with('status', 'Вы обновили данные');
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Firma  $firma
     * @return \Illuminate\Http\Response
     */
    public function destroy(Firma $firma,FirmaService $firmaservice)
    {
        //Удоляем 
        $result=$firmaservice->delete($firma);
        // от полученого результат выводим сообщение
        if($result>0){
            return redirect('upanel/firma')->with('status', 'Вы удалили запись');
        }else{
            return redirect('upanel/firma')->with('status', 'Не могу удалить запись');
        }
    }

    /**
     * Получаем данные фирмы
     *
     */
    public function ajaxGet(){
        // формируем массив
        $photos = array();
        $datas=Firma::all();
        foreach ($datas as $data){
            array_push($photos,array($data->id,$data->name));
        }
        // возрошаем json
        $myJSON = json_encode($photos);
        // выводим
        echo $myJSON;
    }
}
