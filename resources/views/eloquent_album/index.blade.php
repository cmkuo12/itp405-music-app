@extends('layouts.main')

@section('title', 'Albums')

@section('content')
    <div class="text-end mb-3">
        @if (Auth::check())
            <a href="{{route('eloquent_album.create')}}">New Album</a>
        @endif
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Album</th>
                <th>Artist</th>
                <th>Creator</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($albums as $album)
                <tr>
                    <td>
                        {{$album->title}}
                    </td>
                    <td>
                        {{$album->artist->name}}
                    </td>
                    <td>
                        {{$album->user->name}}
                    </td>
                    @can ('view', $album)
                        <td>
                            <a href="{{route('eloquent_album.edit', [ 'id' => $album->id] )}}">
                                Edit
                            </a>
                        </td>
                    @endcan
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
