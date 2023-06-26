<?php

use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Facades\Route;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::group(['middleware' => ['auth', 'admin'], 'prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::name('admin.')->group(function () {
        Route::get('/dashboard', function () {

            $user = User::all();
            $service = Service::all();

            return view('dashboard', [
                'user' => $user,
                'service' => $service
            ]);
        })->name('dashboard');

        // Service
        Route::get('service', 'ServiceController@index')->name('service.index');
        Route::get('service/create', 'ServiceController@create')->name('service.create');
        Route::post('service/store', 'ServiceController@store')->name('service.store');
        Route::get('service/{id}/edit', 'ServiceController@edit')->name('service.edit');
        Route::put('service/{id}/update', 'ServiceController@update')->name('service.update');
        Route::delete('service/{id}/delete', 'ServiceController@destroy')->name('service.destroy');

        // Order
        Route::get('order', 'OrderController@index')->name('order.index');
        Route::get('order/create', 'OrderController@create')->name('order.create');
        Route::post('order/store', 'OrderController@store')->name('order.store');
        Route::get('order/{id}/edit', 'OrderController@edit')->name('order.edit');
        Route::put('order/{id}/update', 'OrderController@update')->name('order.update');
        Route::get('order/{id}/show', 'OrderController@show')->name('order.show');
        Route::delete('order/{id}/delete', 'OrderController@destroy')->name('order.destroy');
        Route::get('order/getService/{id}', 'OrderController@getService')->name('order.getService');
    });
});

require __DIR__ . '/auth.php';
