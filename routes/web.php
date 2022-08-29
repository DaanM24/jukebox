<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\PermPlaylistController;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/songlist', function () {
    $song = DB::table('songs')->get();
    return view('songlist', ['song' => $song]);
});

Route::get('/songdetails/{id}', function ($id) {
    $song = DB::table('songs')
                ->where('id', '=', $id)
                ->get();
    return view('songdetails', ['song' => $song]);
});

Route::get('/genres', function () {
    $genre = DB::table('genres')->get();
    return view('genres', ['genre' => $genre]);
});

Route::get('/genre/{id}', function ($id){
    $genre = DB::table('songs')
                ->where('genre', '=', $id)
                ->get();
    return view('genre', ['genre' => $genre]);
});

Route::get('/playlists', function () {
    $playlist = DB::table('playlists')->get();
    return view('playlists', ['playlist' => $playlist]);
});

Route::get('/playlistname', function () {
    return view('playlistname');
});

Route::get('/playlistrename', function () {
    return view('playlistrename');
});

Route::get('/playlistselector', function () {
    $playlist = DB::table('playlists')->get();
    return view('playlistselector', ['playlist' => $playlist]);
});

Route::get('/playlistdetails/{id}', function ($id) {
    $name = DB::table('playlists')
                ->where('id', '=', $id)
                ->get();

    $select = DB::table('saved_songs')
                ->where('listid', '=', $id)
                ->get();
    
    $song = DB::table('songs')->get();

    // dd($select);

    return view('playlistdetails', ['name' => $name, 'select' => $select, 'song' => $song]);
});

Route::get('/playlistdetails/{id}/addSong', [PermPlaylistController::class, 'addSong']);

Route::post('/playlistdetails/add', [PermPlaylistController::class, 'add']);

Route::get('/playlistdetails/{id}/remove', [PermPlaylistController::class, 'remove']);

Route::get('/playlistdetails/{id}/rename', [PermPlaylistController::class, 'storeName']);

Route::post('/playlistdetails/rename', [PermPlaylistController::class, 'changeName']);
 
Route::get('/playlist/{id}/add', [PlaylistController::class, 'add']);

Route::get('/playlist/{id}/remove', [PlaylistController::class, 'remove']);

Route::post('/playlist/create', [PlaylistController::class, 'create']);

Route::get('/playlist', function () {
    $song = DB::table('songs')->get();
    $value = session('playlists');

    return view('playlist', ['value' => $value, 'song' => $song]);
});

require __DIR__.'/auth.php';
