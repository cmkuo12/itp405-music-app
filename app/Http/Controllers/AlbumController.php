<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function index()
    {
        $albums = DB::table('albums')
            ->join('artists', 'artists.id', '=', 'albums.artist_id')
            ->orderBy('artist')
            ->orderBy('title')
            ->get([
                'albums.id',
                'albums.title',
                'artists.name AS artist'
            ]);
        return view('album.index', [
            'albums' => $albums
        ]);
    }

    public function create()
    {
        $artists = DB::table('artists')->orderBy('name')->get();
        return view('album.create', [
            'artists' => $artists,
        ]);
    }

    public function store(Request $request) //request object containing all data coming in from the request (what is typed into the form)
    {
        $request->validate([
            'title' => 'required|max:20', //'|' key to add requirement
            'artist' => 'required|exists:artists,id', //must exist in artists table under id column
        ]);
        
        DB::table('albums')->insert([
           'title' => $request->input('title'),
           'artist_id' => $request->input('artist'),
        ]);

        return redirect()
            ->route('album.index')
            ->with('success', "Successfully created {$request->input('title')}");
        //dd($request->input('artist')); //$_POST['artist']
    }

    public function edit($id)
    {
        $artists = DB::table('artists')->orderBy('name')->get();
        $album = DB::table('albums')->where('id', '=', $id)->first();
        return view('album.edit', [
            'artists' => $artists,
            'album' => $album
        ]);
    }

    public function update($id)
    {

    }
}
