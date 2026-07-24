<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BarangController;


Route::get('/', function () {
    return view('welcome');
});
Route::get('/test',function (){
    return view('test');
});


