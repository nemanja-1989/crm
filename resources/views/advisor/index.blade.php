@extends('layouts.kredium')

@section('title', 'Kredium dashboard')

@section('content')

        <h1>Dashboard</h1>  

        <div>
            <a href="{{ route('clients') }}">View all clients</a>
        </div>

        <div>
            <a href="{{ route('reports') }}">View report</a>
        </div>

        <div>
            <a href="{{ route('logout') }}">
                <button>Logout</button>
            </a>
        </div>
@endsection


