<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Client;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CashLoan extends Model
{
    
    protected $fillable = [
        'user_id',
        'client_id',
        'loan_amount'
    ];

    public function advisor(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
