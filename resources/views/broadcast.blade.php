@extends('layouts.app')

@section('content')

    <div id="app">
        <app status="{{ Session::get('status') }}">
            {{ csrf_field() }}
        </app>
    </div>

@endsection

{{-- @vite(['resources/js/app.js']) // Resource already linked in layouts.app --}}
