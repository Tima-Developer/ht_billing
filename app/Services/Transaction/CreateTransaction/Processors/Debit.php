<?php

namespace App\Services\Transaction\CreateTransaction\Processors;

use App\Models\Transaction;
use App\Services\Transaction\CreateTransaction\Result;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;

class Debit
{
    public function execute($params): Result
    {
        try {
            DB::transaction(function () use ($params) {
                $wallet = Wallet::where('user_id', $params['user_id'])
                    ->first();

                if (!$wallet) {
                    throw new \Exception('Кошелек не найден');
                }

                $balance = (float)$wallet->balance - (float)$params['amount'];

                if ($balance < 0) {
                    throw new \Exception('Недостаточно средств на балансе');
                }

                $wallet->balance = $balance;
                $wallet->save();

                Transaction::create([
                    'source_user_id' => $params['user_id'],
                    'amount' => $params['amount'],
                    'type' => Transaction::TYPE_DEBIT,
                    'description' => $params['description'] ?? '',
                ]);
            });

            return new Result(['message' => 'Транзакция прошла успешно'], 200);
        } catch (\Exception $e) {
            return new Result(['message' => $e->getMessage()], 400);
        }
    }
}
