@extends('layouts.kredium')

@section('title', 'Kredium edit client')

@section('content')

        <h1>Update client</h1>  

        <div>
            <a href="{{ route('clients') }}">
                <button>Go back to clients</button>
            </a>
        </div>

        <h2>Client credentials</h2>

        <form method="POST" action="{{ route('updateClient', $client->id) }}">
            @csrf
            {{ method_field('PATCH') }}
            <input type="text" name="first_name" value="{{ $client->first_name }}">
            <input type="text" name="last_name" value="{{ $client->last_name }}">
            <input type="email" name="email" value="{{ $client->email }}">
            <input type="text" name="phone" value="{{ $client->phone }}">
            <button type="submit">Update client</button>
        </form>

        @if($client->cashLoan && !$client->homeLoan)
            <h2>Cash loan</h2>
                <form method="POST" action="{{ route('updateCashLoan', $client->id) }}">
                    @csrf
                    {{ method_field('PATCH') }}
                    <input type="number" name="loan_amount" value="{{ $client->cashLoan ? $client->cashLoan->loan_amount : '' }}" placeholder="Loan amount">
                    <button type="submit">Update Cash loan</button>
                </form>
                <div style="margin-top: 50px;">
                    <a href="{{ route('resetLoans', $client->id) }}">
                        <button>New loan</button>
                    </a>
                </div>
        @endif

        @if($client->homeLoan && !$client->cashLoan)
            <h2>Home loan</h2>
                <form method="POST" action="{{ route('updateHomeLoan', $client->id) }}">
                    @csrf
                    {{ method_field('PATCH') }}
                    <input type="hidden" name="advisor_id" value="{{ $client->user_id }}">
                    <input type="number" name="property_value" value="{{ $client->homeLoan ? $client->homeLoan->property_value : '' }}" placeholder="Property value">
                    <input type="number" name="down_payment_amount" value="{{ $client->homeLoan ? $client->homeLoan->down_payment_amount : '' }}" placeholder="Down payment amount">
                    <button type="submit">Update Home loan</button>
                </form>
                <div style="margin-top: 50px;">
                    <a href="{{ route('resetLoans', $client->id) }}">
                        <button>New loan</button>
                    </a>
                </div>
        @endif

        @if(!$client->cashLoan && !$client->homeLoan)
            <h2>Cash loan</h2>
            <form method="POST" action="{{ route('updateCashLoan', $client->id) }}">
                @csrf
                {{ method_field('PATCH') }}
                <input type="hidden" name="advisor_id" value="{{ $client->user_id }}">
                <input type="number" name="loan_amount" value="{{ $client->cashLoan ? $client->cashLoan->loan_amount : '' }}" placeholder="Loan amount">
                <button type="submit">Update Cash loan</button>
            </form>

            <h2>Home loan</h2>
            <form method="POST" action="{{ route('updateHomeLoan', $client->id) }}">
                @csrf
                {{ method_field('PATCH') }}
                <input type="number" name="property_value" value="{{ $client->homeLoan ? $client->homeLoan->property_value : '' }}" placeholder="Property value">
                <input type="number" name="down_payment_amount" value="{{ $client->homeLoan ? $client->homeLoan->down_payment_amount : '' }}" placeholder="Down payment amount">
                <button type="submit">Update Home loan</button>
            </form>
        @endif
@endsection

