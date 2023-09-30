<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ExportController;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

Route::get('/', [BookController::class, 'index'])->name('add-book-form');
Route::post('/store-book', [BookController::class, 'store'])->name('store-book');
Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');
// Route::get('/export-csv', [ExportController::class, 'exportCsv'])->name('export.csv');
// Route::get('/export-xml', [ExportController::class, 'exportXml'])->name('export.xml');
Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
Route::put('/books/{id}', 'BookController@update');

// Route::get('/books/{book}/edit', 'BookController@edit')->name('books.edit');
Route::put('/books/{book}', 'BookController@update')->name('books.update');
Route::get('/get-updated-data', 'BookController@getUpdatedData');

Route::get('/export-titles', [ExportController::class, 'exportTitles'])->name('export.titles');
Route::get('/export-authors', [ExportController::class, 'exportAuthors'])->name('export.authors');
Route::get('/export-data', [ExportController::class, 'exportData'])->name('export.data');
Route::patch('/books/{book}', [BookController::class, 'update'])->name('books.update');

Route::get('/export-data', [ExportController::class, 'exportData'])->name('export.data');
Route::get('/generate-file', 'ExportController@generateFile')->name('generate-file');


Route::get('/download/{fileName}', function ($fileName) {
    $filePath = 'tmp/' . $fileName;

    if (Storage::disk('local')->exists($filePath)) {
        $fileContents = Storage::disk('local')->get($filePath);

        $headers = [
            'Content-Type' => 'text/csv', 
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        return Response::make($fileContents, 200, $headers);
    } else {
        abort(404); 
    }
})->name('download');