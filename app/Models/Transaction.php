<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    /**
     * Тип транзакции для снятия денег со счета
     */
    public const TYPE_DEBIT = 'debit';

    /**
     * Тип транзакции для пополнения счета
     */
    public const TYPE_REPLENISHMENT = 'replenishment';

    /**
     * Тип транзакции для перевода со счета на счет
     */
    public const TYPE_TRANSFER = 'transfer';
}
