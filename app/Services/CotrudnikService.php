<?php

namespace App\Services;
// подлкючаем модуль для работы с данными
use App\Models\Cotrudnik;
use Zend\Diactoros\Request;

class CotrudnikService{
    /**
     * Обновляем запись в базе
     * @param Cotrudnik $cotrudnik
     * @param array $array
     */
    public function update(Cotrudnik $cotrudnik,array $array){
        // обновляем значние
        $cotrudnik->name = $array['name'];
        $cotrudnik->fio = $array['fio'];
        // сохроняем
        $cotrudnik->save();
    }
}