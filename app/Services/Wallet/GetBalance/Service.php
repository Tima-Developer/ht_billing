<?php

namespace App\Services\Wallet\GetBalance;

use App\Models\Wallet;
use AshAllenDesign\LaravelExchangeRates\Classes\ExchangeRate;

/**
 * Сервис возвращающий баланс пользователя
 */
class Service
{
    /**
     * Возвращает баланс пользователя
     *
     * @param  int         $user_id
     * @param  string|null $currency
     * @return int
     */
    public function execute(int $user_id, ?string $currency): float
    {
        $wallet = Wallet::where('user_id', $user_id)->first();

        if (empty($wallet)) {
            return 0;
        }

        if (empty($currency)) {
            return $wallet->balance;
        }

        return $this->getExchangeRate($currency, $wallet->balance);
    }

    protected function getExchangeRate(string $currency, float $balance)
    {
        $exchange     = app(ExchangeRate::class);
        $exchangeRate = $exchange->exchangeRate(
            'KZT',
            [$currency]
        );

        return $balance * $exchangeRate[$currency];
    }
}
