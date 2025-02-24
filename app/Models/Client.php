<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CashLoan;
use App\Models\HomeLoan;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Client extends Model
{
    
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
    ];

    public function cashLoan(): HasOne
    {
        return $this->hasOne(CashLoan::class, 'client_id', 'id');
    }

    public function homeLoan(): HasOne
    {
        return $this->hasOne(HomeLoan::class, 'client_id', 'id');
    }
}
