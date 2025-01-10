<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;


Route::prefix('pages')->group(function () {
    // CRUD routes
    Route::get('/', [PageController::class, 'index'])->name('pages.index');         // List all pages
    Route::get('{id}', [PageController::class, 'show'])->name('pages.show');       // Show a specific page with children
    Route::post('/', [PageController::class, 'store'])->name('pages.store');        // Create a new page
    Route::put('{id}', [PageController::class, 'update'])->name('pages.update');   // Update an existing page
    Route::delete('{id}', [PageController::class, 'destroy'])->name('pages.destroy'); // Delete a page

});
// Dynamic route for slug-based resolution
Route::get('{segments}', [PageController::class, 'resolveNestedPage'])
    ->where('segments', '.*')
    ->name('pages.resolve');
