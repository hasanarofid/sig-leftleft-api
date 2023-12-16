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

Route::get('/', 'OutletMapController@index');

Auth::routes();

Route::get('/home', 'OutletMapController@index')->name('outlet_map.index');

/*
 * Outlets Routes
 */
Route::get('/our_outlets', 'OutletMapController@index')->name('outlet_map.index');
Route::resource('outlets', 'OutletController');


Route::get('/get-provinsi', 'RegionController@provinsi')->name('get-provinsi');
Route::get('/get-kabupaten', 'RegionController@kabupaten')->name('get-kabupaten');
Route::get('/get-kecamatan', 'RegionController@kecamatan')->name('get-kecamatan');
Route::get('/get-desa', 'RegionController@desa')->name('get-desa');