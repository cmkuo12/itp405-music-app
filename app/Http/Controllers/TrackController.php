<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TrackController extends Controller
{
    public function index()
    {
        $tracks = DB::table('tracks')
            ->join('albums', 'tracks.album_id', '=', 'albums.id')
            ->join('artists', 'albums.artist_id', '=', 'artists.id')
            ->join('genres', 'tracks.genre_id', '=', 'genres.id')
            ->join('media_types', 'tracks.media_type_id', '=', 'media_types.id')
            // ->orderBy('artist')
            // ->orderBy('title')
            ->get([
                'tracks.name AS name',
                'albums.title AS album',
                'artists.name AS artist',
                'media_types.name AS media_type',
                'genres.name AS genre',
                'tracks.unit_price AS unit_price'
            ]);

        return view('track.index', [
            'tracks' => $tracks
        ]);
    }

    public function create()
    {
        $albums = DB::table('albums')->orderBy('title')->get();
        $media_types = DB::table('media_types')->orderBy('name')->get();
        $genres = DB::table('genres')->orderBy('name')->get();
        return view('track.create', [
            'albums' => $albums,
            'media_types' => $media_types,
            'genres' => $genres,
        ]);
    }

    public function store(Request $request) //request object containing all data coming in from the request (what is typed into the form)
    {
        $request->validate([
            'name' => 'required|max:50', //'|' key to add requirement
            'album' => 'required|exists:albums,id',
            'media_type' => 'required|exists:media_types,id',
            'genre' => 'required|exists:genres,id',
            'unit_price' => 'required|max:50',
        ]);
        
        DB::table('tracks')->insert([
           'name' => $request->input('name'),
           'album_id' => $request->input('album'),
           'media_type_id' => $request->input('media_type'),
           'genre_id' => $request->input('genre'),
           'unit_price' => $request->input('unit_price'),
        ]);

        return redirect()
            ->route('track.index')
            ->with('success', "The track {$request->input('name')} was successfully created");
        //dd($request->input('artist')); //$_POST['artist']
    }
}
