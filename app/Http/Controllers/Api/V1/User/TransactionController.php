<?php
namespace App\Http\Controllers\Api\V1\User;

use App\Models\User;
use App\Models\Transaction;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;

class TransactionController extends Controller
{
    public function show(User $user, Transaction $transaction)
    {
        $this->authorize('show', $transaction);

        return response()->json(new TransactionResource($transaction));
    }
}
