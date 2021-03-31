<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceAttachmentController;

use App\Http\Controllers\SectionController;
use App\Http\Controllers\ProductController;



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
    return view('auth.login');
});
Auth::routes();
/*
if we want to have one admin only
Auth::routes(['register'=>false]);

*/

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('invoices', InvoiceController::class);
Route::resource('sections', SectionController::class);
Route::resource('products', ProductController::class);
Route::get('/section/{id}',InvoiceController::class.'@getProducts');
Route::get('download/{invoice_number}/{file_name}',InvoiceController::class.'@getfile');
Route::get('view_file/{invoice_number}/{file_name}',InvoiceController::class.'@openfile');
Route::post('/delete_file',InvoiceAttachmentController::class.'@destroy')->name('delete_file');

Route::get('/{page}',AdminController::class.'@index');

