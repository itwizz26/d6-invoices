<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\InvoicesController;

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
    return view('invoice');
});
Route::get('/error', function () {
    return view('error');
});
// The preview page
Route::post('/invoices/preview', [InvoicesController::class, 'store'])->name('preview');
// The PDF generator
Route::get('/invoices/generate/{id}', [InvoicesController::class, 'generatePDF'])->name('generate');
// The historic invoices list
Route::get('/invoices/list', [InvoicesController::class, 'getAllInvoices'])->name('list');
