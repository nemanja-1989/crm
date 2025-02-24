<div>
    <a href="{{ route('clients') }}">
        <button>Go back to clients</button>
    </a>
</div>

<form method="POST" action="{{ route('storeClient') }}">
    @csrf
    <input type="text" name="first_name" placeholder="First name">
    <input type="text" name="last_name" placeholder="Last name">
    <input type="email" name="email" placeholder="Email">
    <input type="text" name="phone" placeholder="Phone">
    <button type="submit">Create client</button>
</form>
