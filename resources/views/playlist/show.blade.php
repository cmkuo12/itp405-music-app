@extends('layouts.main')

@section('title')
    Playlists: {{$playlist->name}}
@endsection

@section('content')
    <a href="{{route('playlist.index')}}" class="d-block mb-3">Back to Playlists</a>
    <p>Total Tracks: {{$tracks->count()}}</p>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Track</th>
                <th>Album</th>
                <th>Artist</th>
                <th>Genre</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tracks as $track)
                <tr>
                    <td>{{$track->track_name}}</td>
                    <td>{{$track->album_name}}</td>
                    <td>{{$track->artist_name}}</td>
                    <td>${{$track->genre_name}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection