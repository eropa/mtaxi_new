<?php

namespace App\Services;

use App\Models\Drive;
use App\Models\Firma;

class  FirmaService{
    /**
     * Создаем новую запись
     * @param array $array
     */
    public function create(array $array){
        // экземпдяр класса
        $model=new Firma();
        // Заполняем данные
        $model->name=$array['name'];
        $model->nomerorganiz=$array['nomerorganiz'];
        $model->address=$array['address'];
        // сохроняем данные
        $model->save();
    }

    /**
     * Новое значение записываем
     * @param Firma $firma новая запись
     * @param array $array массив значений
     */
    public function update(Firma $firma,array $array){
        // сохроняем новые значени
        $firma->name=$array['name'];
        $firma->nomerorganiz=$array['nomerorganiz'];
        $firma->address=$array['address'];
        // сохроняем данные
        $firma->save();
    }

    /**
     *
     * @param Firma $firma
     */
    public function delete(Firma $firma){
        $modelDrive=new Drive();
        $count = Drive::where('firmaid', $firma->id)->count();
        if($count>0){
            //return redirect('upanel/firma')->with('status', 'Нельзя удалить, есть такая фирма у водителя');
            return 0;
        }else{
            $firma->delete();
            return 1;
        }



    }

}