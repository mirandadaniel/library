<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ExportController;

Route::get('/', [BookController::class, 'index'])->name('add-book-form');
Route::post('/store-book', [BookController::class, 'store'])->name('store-book');
Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');
Route::get('/export-csv', [ExportController::class, 'exportCsv'])->name('export.csv');
Route::get('/export-xml', [ExportController::class, 'exportXml'])->name('export.xml');
Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
Route::put('/books/{id}', 'BookController@update');

Route::get('/books/{book}/edit', 'BookController@edit')->name('books.edit');
Route::put('/books/{book}', 'BookController@update')->name('books.update');
Route::get('/get-updated-data', 'BookController@getUpdatedData');
