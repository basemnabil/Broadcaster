@extends('layouts.app')

@section('content')
    <div id="app">
        <broadcast-log :log="{{ @json_encode($log) }}" >

        </broadcast-log>
    </div>
@endsection
