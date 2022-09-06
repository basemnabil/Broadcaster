@extends('layouts.app')

@section('content')

    <div id="app">
        <app status="{{ Session::get('status') }}">
            {{ csrf_field() }}
        </app>
    </div>
    {{-- <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header pb-0"><h4><strong>BroadcastController</strong></h4></div>

                    <form method="post" action="{{url('/send')}}">
                        @csrf
                        <div class="card-body">
                            <div id="app">
                            <radioButton texts="Expired Projects" id="radioButton" name="radioButton"></radioButton>

                            <div class="col-10 pt-3">
                                <v-input text="Subject" name="subject" id="subject"></v-input>
                            </div>
                            <div class="col-10 pt-3">
                                <v-textarea text="Content" name="content" id="content"></v-textarea>
                            </div>
                        </div>

                        <div class="p-3 pt-0 float-end">
                            <input type="submit" class="btn btn-success" value="Send">
                        </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}

@endsection

{{--@vite(['resources/js/app.js'])--}}
