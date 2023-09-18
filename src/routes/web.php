<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ExportController;



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

Route::get('/', [BookController::class, 'index'])->name('add-book-form');
Route::post('/store-book', [BookController::class, 'store'])->name('store-book');
Route::delete('/books/{book}', 'BookController@delete')->name('books.delete');
Route::get('/export-csv', [ExportController::class, 'exportCsv'])->name('export.csv');
Route::get('/export-xml', [ExportController::class, 'exportXml'])->name('export.xml');