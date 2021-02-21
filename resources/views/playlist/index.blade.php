@extends('layouts.main')

@section('title')
    Playlists
@endsection

@section('content')
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Action</th>
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
                    <td>
                        <a href="{{route('playlist.edit', [ 'id' => $playlist->id] )}}">
                            Rename
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
