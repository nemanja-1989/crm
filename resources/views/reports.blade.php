<div>
    <a href="{{ route('dashboard') }}">
        <button>Back to dashboard</button>
    </a>
</div>

<h2>Reports</h2>

<table>
  <tr>
    <th>Product type</th>
    <th>Product value</th>
    <th>Client email</th>
    <th>Creation date</th>
  </tr>
  @foreach ($reports as $report)
        <tr>
            <td>{{ $report->property_value ? 'Home loan' : 'Cash Loan' }}</td>
            @if($report->property_value)
                <td>{{ $report->property_value }} - {{ $report->down_payment_amount }}</td>
            @else 
                <td>{{ $report->loan_amount }}</td>
            @endif
            <td>{{ $report->client->email }}</td>
            <td>{{ $report->created_at }}</td>
        </tr>
    @endforeach
</table>