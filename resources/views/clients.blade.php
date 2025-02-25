
@extends('layouts.kredium')

@section('title', 'Kredium clients')

@section('content')

    <h1>Clients:</h1>

    <div>
        <a href="{{ route('dashboard') }}">
            <button>Back to dashboard</button>
        </a>
    </div>
    <div>
        <a href="{{ route('createClient') }}">
            <button>Create client</button>
        </a>
    </div>


    @if($clients->count() > 0)

    <table>
    <tr>
        <th>First name</th>
        <th>Last name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Cash loan</th>
        <th>Home loan</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>
        @foreach ($clients as $client)
            <tr>
                <td>{{ $client->first_name }}</td>
                <td>{{ $client->last_name }}</td>
                <td>{{ $client->email }}</td>
                <td>{{ $client->phone }}</td>
                <td>{{ $client->cashLoan ? 'yes' : 'no' }}</td>
                <td>{{ $client->homeLoan ? 'yes' : 'no' }}</td>
                <td><a href="{{ route('editClient', $client->id) }}"><button>Edit</button></a></td>
                <td>
                    <form method="POST" action="{{ route('deleteClient', $client->id) }}">
                        @csrf
                        {{ method_field('DELETE') }}
                            <button>Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

    @endif
@endsection

