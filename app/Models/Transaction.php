<?php
namespace App\Models;

use App\Enums\TransactionStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Transaction extends Model
{
    use HasFactory;

    protected $casts = [
        'status' => TransactionStatus::class
    ];
    protected $fillable = ['category_id', 'subcategory_id', 'amount', 'customer_id', 'due', 'vat', 'is_vat_inclusive', 'status'];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Category::class, 'subcategory_id');
    }

    public function getStatusattribute()
    {
        if (!$this->payments && $this->isTodayGteFromDueDate() || $this->isTodayGteFromDueDate()) {
            return TransactionStatus::Outstanding;
        }

        if ($this->payments()->exists() && $this->payments->sum('amount') >= $this->amount) {
            return TransactionStatus::Paid;
        }

        return TransactionStatus::Overdue;
    }

    private function isTodayGteFromDueDate()
    {
        return Carbon::create($this->due)->gte(today());
    }
}
