<?php
namespace App\Http\Controllers\Api\V1\Admin;

use App\Models\Transaction;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReportRequest;
use App\Http\Resources\ReportResource;

class ReportController extends Controller
{
    public function report(ReportRequest $reportRequest)
    {
        $report = Transaction::query()
            ->leftJoin('payments', 'transactions.id', '=', 'payments.transaction_id')
            ->selectRaw('COALESCE(sum(payments.amount),0) as paid')
            ->selectRaw('COALESCE(sum(CASE WHEN transactions.status = "overdue" THEN payments.amount ELSE 0 END),0) as overdue')
            ->selectRaw('COALESCE(sum(CASE WHEN transactions.status = "outstanding" THEN payments.amount ELSE 0 END),0) as outstanding')
            ->whereBetween('transactions.due', [$reportRequest->starting_date, $reportRequest->ending_date])
            ->first();

        $report->from_date = $reportRequest->starting_date;
        $report->to_date = $reportRequest->ending_date;

        return response()->json(new ReportResource($report));
    }

    public function monthlyReport(ReportRequest $reportRequest)
    {
        $report = Transaction::query()
            ->leftJoin('payments', 'transactions.id', '=', 'payments.transaction_id')
            ->selectRaw('MONTHNAME(due) as month')
            ->selectRaw('year(due) as year')
            ->selectRaw('COALESCE(sum(payments.amount),0) as paid')
            ->selectRaw('COALESCE(sum(CASE WHEN transactions.status = "overdue" THEN payments.amount ELSE 0 END),0) as overdue')
            ->selectRaw('COALESCE(sum(CASE WHEN transactions.status = "outstanding" THEN payments.amount ELSE 0 END),0) as outstanding')
            ->whereBetween('transactions.due', [$reportRequest->starting_date, $reportRequest->ending_date])
            ->orderBy('month')
            ->groupBy('month', 'year')
            ->paginate();

        return response()->json(ReportResource::collection($report)->resource);
    }
}
