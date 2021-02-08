@extends('layouts.main')

@section('title')
    Playlists
@endsection

@section('content')
    <table>
        <thead>
            <tr>
                <th>Playlist Collection</th>
            </tr>
        </thead>
        <tbody>
            @foreach($playlists as $playlist)
                <tr>
                    <td>
                        <a href="{{route('playlist.show', [ 'id' => $playlist->id])}}">
                            {{$playlist->name}}
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
