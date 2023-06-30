<?php

namespace App\Services\Transaction\CreateTransaction\Processors;

use App\Models\Transaction;
use App\Models\Wallet;
use App\Services\Transaction\CreateTransaction\Result;
use Illuminate\Support\Facades\DB;

/**
 * Процессор для пополнения счета
 */
class Replenishment
{
    /**
     * Пополнение счета
     *
     * @param  array                                              $params
     * @return \App\Services\Transaction\CreateTransaction\Result
     */
    public function execute(array $params): Result
    {
        DB::transaction(function () use ($params) {
            $wallet = Wallet::firstOrCreate(['user_id' => $params['user_id']], ['balance' => 0.00]);

            $wallet->balance = (float) $wallet->balance + (float) $params['amount'];
            $wallet->save();

            Transaction::create([
                'source_user_id' => $params['user_id'],
                'amount'         => $params['amount'],
                'type'           => Transaction::TYPE_REPLENISHMENT,
                'description'    => $params['description'] ?? '',
            ]);
        });

        return new Result(['message' => 'Транзакция прошла успешно'], 200);
    }
}
