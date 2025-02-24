<?php

namespace App\Exports;

use App\Models\CashLoan;
use App\Models\HomeLoan;
use Maatwebsite\Excel\Concerns\FromCollection;

class ReportsExport implements FromCollection
{
    public function collection()
    {

        $cashLoan = CashLoan::with(['advisor', 'client'])->get();
        $homeLoan = HomeLoan::with(['advisor', 'client'])->get();

        return $cashLoan->concat($homeLoan)->sortByDesc('created_at');

    }
}