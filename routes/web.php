<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Auth::routes();

// Auth::routes();
//Route::get('/login', 'Auth\LoginController@showLoginForm' );
//Route::post('/login', 'Auth\LoginController@login');
//Route::post('/logout', 'Auth\LoginController@logout');


// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
//Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
//Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');



Route::get('/home', 'HomeController@index')->name('home');

Route::get('/test',function(){
    return view('back.index');
});

Route::middleware(['auth'])->group(function () {
    // Справочник водителей
    Route::resource('upanel/driver', 'DriveController');

    // Спровочник автомобилей
    Route::resource('upanel/car', 'CarController');

    // Справочник фирма
    Route::resource('upanel/firma', 'FirmaController');

    // Справочник сотрудников
    Route::resource('upanel/cotrudnik', 'CotrudnikController');

    // Главная страница
    Route::get('upanel',function(){
        return view('back.index');
    });

    // форма для печати
    Route::get('upanel/print','DriveController@printform');
   // Route::post('upanel/print','DriveController@print_fpdi',function (){});

    // открываем страницу для формирование пдф файла
    Route::get('upanel/pdf/{id?}/{datastart?}/{dataend?}','DriveController@print_get',
        function ($id = null,$datastart=null,$dataend=null) {
        return 0;
    });

    // получаем данные фирм с помощью аякс
    Route::get('upanel/updatefirma','FirmaController@ajaxGet');

    // получаем путевый лист
    Route::get('upanel/driver/countrecord/{fio?}/{gosnomer?}','DriveController@CountRecord',
        function ($fio = null,$gosnomer=null)
        {
            return 0;
        }
    );

    // получаем данные когда формировали путевой лист по конкретному водителю
    Route::get('upanel/driver/log/{id?}','DriveController@print_log_pdf',
        function ($id = 0)
        {
        }
    );

});
