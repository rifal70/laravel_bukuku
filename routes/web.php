<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScrapeController;
use App\Jobs\DeleteAllDataJob;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/scrape-and-save', [ScrapeController::class, 'scrapeAndSave']);

Route::post('/delete-all-data', function () {
    dispatch(new DeleteAllDataJob());
    return 'Proses berhasil ditambahkan pada Job';
});
