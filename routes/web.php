<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\TrackController;
use Illuminate\Support\Facades\Route;
use App\Models\Artist;
use App\Models\Track;
use App\Models\Genre;
use App\Models\Album;
use Illuminate\Support\Facades\URL;



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

// MVC - Model View Controller

//get to read information
Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoice.index');
Route::get('/invoices/{id}', [InvoiceController::class, 'show'])->name('invoice.show');

Route::get('/playlists', [PlaylistController::class, 'index'])->name('playlist.index');
Route::get('/playlists/{id}', [PlaylistController::class, 'show'])->name('playlist.show');
Route::get('/playlists/{id}/edit', [PlaylistController::class, 'edit'])->name('playlist.edit');
Route::post('/playlist/{id}', [PlaylistController::class, 'update'])->name('playlist.update');

Route::get('/albums', [AlbumController::class, 'index'])->name('album.index');
Route::get('/albums/create', [AlbumController::class, 'create'])->name('album.create');
Route::post('/albums', [AlbumController::class, 'store'])->name('album.store'); //same url but with post request to take in info from the form created
Route::get('/albums/{id}/edit', [AlbumController::class, 'edit'])->name('album.edit');
Route::post('/albums/{id}', [AlbumController::class, 'update'])->name('album.update');

Route::get('/tracks', [TrackController::class, 'index'])->name('track.index');
Route::get('/tracks/new', [TrackController::class, 'create'])->name('track.create');
Route::post('/tracks', [TrackController::class, 'store'])->name('track.store');

Route::get('/eloquent', function() {
    //QUERYING
    // return view('eloquent.tracks', [
    //     'tracks' => Track::all(),
    // ]);

    // return view('eloquent.artists', [
    //     'artists' => Artist::orderBy('name', 'desc')->get(),
    // ]);

    // return view('eloquent.tracks', [
    //     'tracks' => Track::where('unit_price', '>', 0.99)->orderBy('name')->get(),
    // ]);

    // return view('eloquent.artist', [
    //     'artist' => Artist::find(3),
    // ]);

    //CREATING NEW ENTRY
    // $genre = new Genre(); //corresponds to single row in genres table
    // $genre->name = 'Hip Hop';
    // $genre->save();

    //DELETING ENTRY
    // $genre = Genre::find(27); //corresponds to single row in genres table
    // $genre->delete();

    //UPDATING ENTRY
    // $genre = Genre::where('name', '=', 'Alternative and Punk')->first();
    // $genre->name = 'Alternative & Punk';
    // $genre->save();

    //RELATIONSHIPS
    // return view('eloquent.has-many', [
    //     'artist' => Artist::find(50), //Metallica
    // ]);

    // return view('eloquent.belongs-to', [
    //     'album' => Album::find(152),
    // ]);
    
    // EAGER LOADING
    return view('eloquent.eager-loading', [
        // Has the N+1 problem
        // 'tracks' => Track::where('unit_price', '>', 0.99)
        //     ->orderBy('name')
        //     ->limit(5)
        //     ->get(),

        //Fixes the N+1 problem (EAGER LOADING)
        'tracks' => Track::with(['album'])
            ->orderBy('name')
            ->limit(5)
            ->get(),
    ]);
});


if (env('APP_ENV') !== 'local') {
    URL::forceScheme('https');
}