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
}
