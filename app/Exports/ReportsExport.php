<?php

namespace App\Exports;

use App\Models\CashLoan;
use App\Models\HomeLoan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\Auth;

class ReportsExport implements FromCollection, WithMapping
{
    public function collection()
    {

        $cashLoan = CashLoan::with(['advisor', 'client'])->where('user_id', Auth::user()->id)->get();
        $homeLoan = HomeLoan::with(['advisor', 'client'])->where('user_id', Auth::user()->id)->get();

        return $cashLoan->concat($homeLoan)->sortByDesc('created_at');

    }

    public function map($report): array {

        $propertType = null;
        $productValue = null;
        if($report->property_value) {
            $propertType = 'Home loan';
            $productValue = $report->property_value . " - " . $report->down_payment_amount;
        }else {
            $propertType = 'Cash loan';
            $productValue = $report->loan_amount;
        }
        
        return[
            $propertType,
            $productValue,
            $report->client->email,
            $report->created_at->format('Y-m-d')
        ];
    }
}