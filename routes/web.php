<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceAttachmentController;
use App\Http\Controllers\ArchiveInvoiceController;


use App\Http\Controllers\SectionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;




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
Route::post('/attachment',InvoiceAttachmentController::class.'@store')->name('attachment');
Route::get('change_invoice_status/{id}',InvoiceController::class.'@change_invoice_status')->name('change_invoice_status');
Route::post('status_update',InvoiceController::class.'@status_update')->name('status_update');
Route::get('paid_invoices',InvoiceController::class.'@paid_invoices')->name('paid_invoices');
Route::get('unpaid_invoices',InvoiceController::class.'@unpaid_invoices')->name('unpaid_invoices');
Route::get('partial_paid_invoices',InvoiceController::class.'@partial_paid_invoices')->name('partial_paid_invoices');
Route::get('invoice_archive',ArchiveInvoiceController::class.'@index')->name('invoice_archive');

Route::post('archive_invoices',InvoiceController::class.'@archive_invoices')->name('archive_invoices');
Route::get('print_invoice/{id}',InvoiceController::class.'@print_invoice')->name('print_invoice');

Route::post('restore_invoices',ArchiveInvoiceController::class.'@restore_invoices')->name('restore_invoices');
Route::post('delete_archived',ArchiveInvoiceController::class.'@destroy')->name('delete_archived');
Route::get('invoice/export/', InvoiceController::class.'@export')->name('export_invoices');

Route::group(['middleware'=> ['auth']],function () {
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);


});











Route::get('/{page}',AdminController::class.'@index');

