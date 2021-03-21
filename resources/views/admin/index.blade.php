@extends('layouts.main')

@section('title', 'Admin')

@section('content')
    <form method="post" action="{{ route('admin.configure') }}">
        @csrf
        <div class="mt-3 mb-3">
            <label for="maintenance-mode">Maintenance Mode</label>
            <input
                type="checkbox"
                id="maintenance-mode"
                name="maintenance-mode"
                {{ $maintenance_state === true ? 'checked' : '' }}>
        </div>
        <button type="submit" class="btn btn-primary">
            Save
        </button>
    </form>
@endsection