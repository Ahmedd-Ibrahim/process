<?php
namespace App\Http\Controllers\Api\V1\Admin;

use App\Models\Transaction;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Http\Resources\TransactionResource;

class TransactionController extends Controller
{
    public function index()
    {
        return response()->json(TransactionResource::collection(Transaction::paginate())->resource);
    }

    public function store(TransactionRequest $request)
    {
        $transaction = Transaction::create($request->validated());
        return response()->json(new TransactionResource($transaction));
    }

    public function update(Transaction $transaction, TransactionRequest $request)
    {
        $transaction->update($request->validated());
        return response()->json(new TransactionResource($transaction));
    }

    public function show(Transaction $transaction)
    {
        return response()->json($transaction);
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return response()->json(['message' => 'Transaction deleted successfully']);
    }
}
