<?php
namespace App\Enums;

enum TransactionStatus: string
{
    case Paid = 'paid';
    case Outstanding = 'outstanding';
    case Overdue = 'overdue';
}
