<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ExportController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [BookController::class, 'index'])->name('add-book-form');
Route::post('/store-book', [BookController::class, 'store'])->name('store-book');
Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');
Route::get('/export-csv', [ExportController::class, 'exportCsv'])->name('export.csv');
Route::get('/export-xml', [ExportController::class, 'exportXml'])->name('export.xml');