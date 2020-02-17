<?php

namespace App\Services;
// подлкючаем модуль для работы с данными
use App\Models\Car;
use Zend\Diactoros\Request;

class CarService{

    /**
     * Добовлене новой записи
     * @param array $array Массив значений
     */
    public function create(array $array){
        // экземпдяр класса
        $model=new Car();
        // Заполняем данные
        $model->name=$array['nameAvto'];
        // сохроняем данные
        $model->save();
    }

    /**
     * Обновлям значение
     * @param Car $car
     * @param Request $request
     */
    public function update(Car $car,array $array){

        // обновляем значние
        $car->name = $array['nameAvto'];
        // сохроняем
        $car->save();
    }

}
