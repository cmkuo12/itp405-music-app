<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PlaylistController extends Controller
{
    //"playlists" index page
    public function index()
    {
        $playlists = DB::table('playlists')
            ->orderBy('id')
            ->get([
                'name',
                'id'
            ]);

        return view('playlist.index', [
            'playlists' => $playlists
        ]);
    }

    //"tracks" page for a specific playlist
    public function show($id)
    {
        $playlist = DB::table('playlists')
            ->where('id', '=', $id)
            ->first();

        $tracks = DB::table('playlist_track')
            ->where('playlist_id', '=', $id)
            ->join('tracks', 'playlist_track.track_id', '=', 'tracks.id')
            ->join('albums', 'tracks.album_id', '=', 'albums.id')
            ->join('artists', 'albums.artist_id', '=', 'artists.id')
            ->join('genres', 'tracks.genre_id', '=', 'genres.id')
            ->get([
                'tracks.name AS track_name',
                'albums.title AS album_name',
                'artists.name AS artist_name',
                'genres.name AS genre_name'
            ]);

        return view('playlist.show', [
            'playlist' => $playlist,
            'tracks' => $tracks
        ]);
    }

    public function edit($id)
    {
        $playlist = DB::table('playlists')->where('id', '=', $id)->first();
        return view('playlist.edit', [
            'playlist' => $playlist,
        ]);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'name' => 'required|max:30|unique:playlists,name',
        ]);
        
        $old_playlist = DB::table('playlists')->where('id', '=', $id)->first();

        DB::table('playlists')->where('id', '=', $id)->update([
            'name' => $request->input('name'),
        ]);

        return redirect()
            ->route('playlist.index')
            ->with('success', "{$old_playlist->name} was successfully renamed to {$request->input('name')}");
    }
}
