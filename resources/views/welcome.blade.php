@extends('layouts.kredium')

@section('title', 'Kredium loan')

@section('content')

        <h1>Kredium loans</h1>  

        <div>
            <a href="{{ route('login-page') }}">
                <button>Log in</button>
            </a>
        </div>
@endsection