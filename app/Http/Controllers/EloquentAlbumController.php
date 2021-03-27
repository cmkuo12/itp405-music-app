<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\Album;
use App\Models\Artist;

class EloquentAlbumController extends Controller
{
    public function index()
    {
        $albums = Album::join('artists', 'artists.id', '=', 'albums.artist_id')
            ->with(['artist'])
            ->with(['user'])
            ->orderBy('artists.name')
            ->orderBy('title')
            ->select('*', 'albums.id as id')
            ->get();

        return view('eloquent_album.index', [
            'albums' => $albums,
        ]);
    }

    public function create()
    {
        $artists = Artist::orderBy('name')->get();
        return view('eloquent_album.create', [
            'artists' => $artists,
        ]);
    }

    public function store(Request $request) //request object containing all data coming in from the request (what is typed into the form)
    {
        $request->validate([
            'title' => 'required|max:50', //'|' key to add requirement
            'artist' => 'required|exists:artists,id', //must exist in artists table under id column
        ]);
        
        $new_album = new Album();
        $new_album->title = $request->input('title');
        $new_album->artist_id = $request->input('artist');
        $new_album->save();

        return redirect()
            ->route('eloquent_album.index')
            ->with('success', "Successfully created {$request->input('title')}");
    }

    public function edit($id)
    {
        $artists = Artist::orderBy('name')->get();
        $album = Album::where('id', '=', $id)->first();
        return view('eloquent_album.edit', [
            'artists' => $artists,
            'album' => $album,
        ]);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'title' => 'required|max:50', //'|' key to add requirement
            'artist' => 'required|exists:artists,id', //must exist in artists table under id column
        ]);

        $album = Album::where('id', '=', $id)->first();
        $album->title = $request->input('title');
        $album->artist_id = $request->input('artist');
        $album->save();

        return redirect()
            ->route('eloquent_album.edit', ['id' => $id])
            ->with('success', "Successfully updated {$request->input('title')}");
    }
}
