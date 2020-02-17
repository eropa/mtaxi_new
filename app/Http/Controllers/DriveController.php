<?php

namespace App\Http\Controllers;

use App\Http\Requests\DriveRequest;
use App\Models\Car;
use App\Models\Drive;
use App\Models\Firma;
use App\Services\DriveService;
use App\Services\PrintService;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Http\Request;
use setasign\Fpdi\Fpdi;

class DriveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('back.drive.index',['datas'=>Drive::all()]);
        //
    }

    /**
     * формируем форму для выбора водителя печати
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function printform(){
        return view('back.drive.print',['datas'=>Drive::all()]);
    }

    /**
     * выводим на печать
     * @param Request $request
     * @param PrintService $printservice
     *
     */
    public function print_fpdi(Request $request,PrintService $printservice){
        // получаем данные
        $data=Drive::find($request->input('id_'));
        $printservice->InsertLogPrint($data,$request->input('trip-start'),$request->input('trip-end'));
        // Выводим на пдф печать
       // $printservice->printPdf($data,$request->input('trip-start'),$request->input('trip-end'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // показываем предстовление для добавления
        return view('back.drive.create',['datacars'=>Car::all(),'datafirms'=>Firma::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DriveRequest $request,DriveService $driveservice)
    {

        // добовляем данные
        $driveservice->create($request->all());
        // переходим на страницу
        return redirect('upanel/driver')->with('status', 'Вы обновили данные');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Drive  $drive
     * @return \Illuminate\Http\Response
     */
    public function show(Drive $drive)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Drive  $drive
     * @return \Illuminate\Http\Response
     */
    public function edit(Drive $driver)
    {


       return view('back.drive.edit',['datacars'=>Car::all(),
                                       'datafirms'=>Firma::all(),
                                        'data'=>$driver]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Drive  $drive
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Drive $driver,DriveService $driveservice)
    {
        // обновляем данные
        $driveservice->update($driver,$request->all());
        // переходим на список водителей
        return redirect('upanel/driver')->with('status', 'Вы обновили данные');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Drive  $drive
     * @return \Illuminate\Http\Response
     */
    public function destroy(Drive $driver)
    {
        // удоляем данные
        $driver->delete();
        // переходим данные
        return redirect('upanel/driver')->with('status', 'Вы удалили данные');
        //
    }

    /**
     * Открываем форму
     * @param null $id
     * @param null $datastart
     * @param null $dataend
     * @param PrintService $printservice
     */
    public function print_get($id = null,$datastart=null,$dataend=null,PrintService $printservice){
        // получаем данные
        $data=Drive::find($id);
        // записываем в лог
        $printservice->InsertLogPrint($data,$datastart,$dataend);
        // Выводим на пдф печать
        $printservice->printPdf($data,$datastart,$dataend);
    }

    /**
     * Получаем логирование
     * @param int $id
     * @param PrintService $printservice
     */
    public function print_log_pdf($id=0,PrintService $printservice){
        // выводим данные
        $result=$printservice->PrintLogId($id);
        if($result==0){
            return "нету записей в базе";
        }
    }
}
