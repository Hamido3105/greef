<?php

use App\Http\Controllers\DocumentController;
use Illuminate\Support\Facades\Route;
use App\Exports\DocumentsExport;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/', function () {
    return view('welcome');
});

Route::get('documents', [DocumentController::class, 'index'])->name('documents.index');
Route::get('documents/create', [DocumentController::class, 'create'])->name('documents.create');
Route::post('documents', [DocumentController::class, 'store'])->name('documents.store');

// Change the parameter in the routes to accept the dash format
Route::get('documents/{custom_id}', [DocumentController::class, 'show'])
    ->where('custom_id', '[0-9]{4}-[0-9]{3}')->name('documents.show');

Route::get('documents/{custom_id}/edit', [DocumentController::class, 'edit'])
    ->where('custom_id', '[0-9]{4}-[0-9]{3}')->name('documents.edit');

Route::put('documents/{custom_id}', [DocumentController::class, 'update'])
    ->where('custom_id', '[0-9]{4}-[0-9]{3}')->name('documents.update');



Route::get('documents/export', function () {
    return (new DocumentsExport)->export();
})->name('documents.export');


Route::post('documents/import', [DocumentController::class, 'import'])->name('documents.import');
