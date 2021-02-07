@extends('layouts.main')

@section('content')
    <table>
        <thead>
            <tr>
                <th>Playlist</th>
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
