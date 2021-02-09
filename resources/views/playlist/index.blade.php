@extends('layouts.main')

@section('title')
    Playlists
@endsection

@section('content')
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
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
