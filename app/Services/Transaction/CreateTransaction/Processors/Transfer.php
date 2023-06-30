<?php

namespace App\Services\Transaction\CreateTransaction\Processors;

use App\Models\Transaction;
use App\Models\Wallet;
use App\Services\Transaction\CreateTransaction\Result;
use Illuminate\Support\Facades\DB;

/**
 * Выполняет перевод со счета на счет
 */
class Transfer
{
    /**
     * Перевод со счета на счет
     *
     * @param  array                                              $params
     * @return \App\Services\Transaction\CreateTransaction\Result
     */
    public function execute(array $params): Result
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

                $destinationWallet = Wallet::firstOrCreate(['user_id' => $params['destination_user_id']], ['balance' => 0.00]);

                $destinationWallet->balance = (float) $destinationWallet->balance + (float) $params['amount'];

                $destinationWallet->save();

                Transaction::create([
                    'source_user_id'      => $params['user_id'],
                    'destination_user_id' => $params['destination_user_id'],
                    'amount'              => $params['amount'],
                    'type'                => Transaction::TYPE_TRANSFER,
                    'description'         => $params['description'] ?? '',
                ]);
            });

            return new Result(['message' => 'Транзакция прошла успешно'], 200);
        } catch (\Exception $e) {
            return new Result(['message' => $e->getMessage()], 400);
        }
    }
}
