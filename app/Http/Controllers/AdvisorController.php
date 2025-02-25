<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Client;
use App\Models\CashLoan;
use App\Models\HomeLoan;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportsExport;

class AdvisorController extends Controller
{

    public function index() {

        return view('advisor/index');
    }

    public function clients() {

        $clients = Client::get();

        return view('clients', [
            'clients' => $clients        
        ]);
    }

    public function reports() {

        $cashLoan = CashLoan::with(['advisor', 'client'])->get();
        $homeLoan = HomeLoan::with(['advisor', 'client'])->get();

        $reports = $cashLoan->concat($homeLoan)->sortByDesc('created_at');

        return view('reports', [
            'reports' => $reports
        ]);
    }

    public function createClient() {

        return view('advisor/create-client');
    }

    public function editClient($client) {

        $client = Client::with(['cashLoan', 'homeLoan'])->whereId($client)->first();

        return view('advisor/edit-client', [
            'client' => $client
        ]);
    }

    public function storeClient(StoreClientRequest $request) {
   
        Client::create([
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone')
        ]);

        return redirect()->intended('clients');
    }

    public function updateClient(UpdateClientRequest $request, $client) {
        
        Client::whereId($client)->update([
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone')
        ]);

        return redirect()->intended('clients');
    }

    public function deleteClient($client) {

        Client::whereId($client)->first()->delete();

        return redirect()->back();
    }

    public function updateCashLoan(Request $request, $client) {

        $client = Client::whereId($client)->first();

        if($client->cashLoan()->exists()) {
            $client->cashLoan()->update([
                'user_id' => auth()->user()->id,
                'loan_amount' => $request->get('loan_amount')
            ]);
        }else {
            $client->cashLoan()->create([
                'user_id' => auth()->user()->id,
                'loan_amount' => $request->get('loan_amount')
            ]);
        }

        return redirect()->intended('clients');
    }

    public function updateHomeLoan(Request $request, $client) {
        
        $client = Client::whereId($client)->first();

        if($client->homeLoan()->exists()) {
            $client->homeLoan()->update([
                'user_id' => auth()->user()->id,
                'property_value' => $request->get('property_value'),
                'down_payment_amount' => $request->get('down_payment_amount')
            ]);
        }else {
            $client->homeLoan()->create([
                'user_id' => auth()->user()->id,
                'property_value' => $request->get('property_value'),
                'down_payment_amount' => $request->get('down_payment_amount')
            ]);
        }

        return redirect()->intended('clients');
    }

    public function resetLoans($client) {

        $client = Client::whereId($client)->first();
        $client->cashLoan()->delete();
        $client->homeLoan()->delete();

        return redirect()->back();
    }

    public function reportsExport() {

        return Excel::download(new ReportsExport, 'reports.csv', \Maatwebsite\Excel\Excel::CSV);
    }
}
