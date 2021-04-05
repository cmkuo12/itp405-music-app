@extends('layouts.email')

@section('content')
    <h1>Stats Report:</h1>
    <div>Number of Artists: {{$artistCount}}</div>
    <div>Number of Playlists: {{$playlistCount}}</div>
    <div>Duration of All Tracks: {{$totalTracksLength}} minutes</div>
@endsection