@extends('layouts.app')

@section('content')

    <div id="app">
        <broadcaster status="{{ Session::get('status') }}">
            {{ csrf_field() }}
        </broadcaster>
    </div>

@endsection

{{-- @vite(['resources/js/app.js']) // Resource already linked in layouts.app --}}
