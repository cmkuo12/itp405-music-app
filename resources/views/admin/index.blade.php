@extends('layouts.main')

@section('title', 'Admin')

@section('content')
    <div class="container mt-3 mb-3">
        <div class="row">
            <div class="col-3">
                <div>Configurations</div>
                <ul class="mt-3 mb-3">
                    <li>
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
                    </li>
                </ul>
                <div>Actions</div>
                <ul class="mt-3 mb-3">
                    <li>
                        <form method="post" action="{{ route('stats') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                Email Stats to Users
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    {{-- <div>
        <h2>Configurations</h2>
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
    </div>
    <div>
        <h2>Actions</h2>
    </div> --}}
@endsection