<?php

namespace App\Services;

use App\Models\Drive;

class DriveService{
    /**
     * Создаем запись
     * @param array $array
     */
    public function create(array $array){
        // Экзепляр класса
        $model=new Drive();
        // Заполняем данные
        $model->name=$array['name'];
        $model->tabelnomer=$array['tabelnomer'];
        $model->garajnomer=$array['garajnomer'];
        $model->driverfio=$array['name'];
        $model->avto=$array['avto'];
        $model->gosnomer=$array['gosnomer'];
        $model->regnomer1=$array['regnomer1'];
        $model->regnomer2=$array['regnomer2'];
        $model->regnomer3=$array['regnomer3'];
        $model->firmaid=$array['firmaid'];
        $model->ydost1=$array['ydost1'];
        $model->ydost2=$array['ydost2'];
        $model->fiosmal=$array['fiosmal'];
        $model->phonedrive=$array['phonedrive'];
        // Сохроняем значение
        $model->save();
    }

    public function update(Drive $driver,array $array){
        // Заполняем данные
        $driver->name=$array['name'];
        $driver->tabelnomer=$array['tabelnomer'];
        $driver->garajnomer=$array['garajnomer'];
        $driver->driverfio=$array['name'];
        $driver->avto=$array['avto'];
        $driver->gosnomer=$array['gosnomer'];
        $driver->regnomer1=$array['regnomer1'];
        $driver->regnomer2=$array['regnomer2'];
        $driver->regnomer3=$array['regnomer3'];
        $driver->firmaid=$array['firmaid'];
        $driver->ydost1=$array['ydost1'];
        $driver->ydost2=$array['ydost2'];
        $driver->fiosmal=$array['fiosmal'];
        $driver->phonedrive=$array['phonedrive'];
        // обновить
        $driver->save();
    }
}