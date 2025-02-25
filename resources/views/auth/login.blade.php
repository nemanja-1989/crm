@extends('layouts.kredium')

@section('title', 'Kredium log in')

@section('content')

        <h1>Log in</h1>  

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <input type="email" name="email" placeholder="Email">
            <input type="password" name="password" placeholder="Password">
            <button type="submit">Login</button>
        </form>
@endsection

