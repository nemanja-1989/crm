<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Http\Requests\CashLoanRequest;
use App\Http\Requests\HomeLoanRequest;
use App\Models\User;
use App\Models\Client;
use App\Models\CashLoan;
use App\Models\HomeLoan;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportsExport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Repositories\ClientRepositoryInterface;

class AdvisorController extends Controller
{

    private ClientRepositoryInterface $clientRepository;

    public function __construct(ClientRepositoryInterface $clientRepository) {

        $this->clientRepository = $clientRepository;
    }

    public function index() {

        return view('advisor/index');
    }

    public function clients() {

        return view('clients', [
            'clients' => $this->clientRepository->all()        
        ]);
    }

    public function reports() {

        $cashLoan = CashLoan::with(['advisor', 'client'])->where('user_id', Auth::user()->id)->get();
        $homeLoan = HomeLoan::with(['advisor', 'client'])->where('user_id', Auth::user()->id)->get();

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

        $data = [
            'user_id' => auth()->user()->id,
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone')
        ];
   
        $this->clientRepository->create($data);

        return redirect()->intended('clients');
    }

    public function updateClient(UpdateClientRequest $request, $client) {
        
        $data = [
            'user_id' => auth()->user()->id,
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone')
        ];

        $this->clientRepository->update($data, $client);

        return redirect()->intended('clients');
    }

    public function deleteClient($client) {

        $client = $this->clientRepository->find($client);

        $this->advisorAuthorization($client);

        $this->clientRepository->delete($client->id);

        return redirect()->back();
    }

    public function updateCashLoan(CashLoanRequest $request, $client) {

        $client = $this->clientRepository->find($client);

        $this->advisorAuthorization($client);

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

    public function updateHomeLoan(HomeLoanRequest $request, $client) {
        
        $client = $this->clientRepository->find($client);

        $this->advisorAuthorization($client);

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

        $client = $this->clientRepository->find($client);

        $this->advisorAuthorization($client);

        $client->cashLoan()->delete();
        $client->homeLoan()->delete();

        return redirect()->back();
    }

    public function reportsExport() {

        return Excel::download(new ReportsExport, 'reports.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    private function advisorAuthorization($client) {
        
        $advisor = User::whereId($client->user_id)->first();

        if (! Gate::forUser($advisor)->allows('loans')) {
            abort(403);
        }
    }
}
