<?php

namespace App\Services\Transaction\CreateTransaction;

use App\Models\Transaction;

/**
 * Сервисный класс для обработки транзакций
 */
class Service
{
    private const TYPE_MAPPER = [
        Transaction::TYPE_DEBIT => Processors\Debit::class,
    ];

    /**
     * Выполняет транзакцию
     *
     * @param  array  $params
     * @param  string $type
     * @return void
     */
    public function execute(array $params, string $type)
    {
        $processorClass = self::TYPE_MAPPER[$type] ?? null;

        if ($processorClass === null) {
            return null;
        }

        $processor = new $processorClass;
        $processor->execute($params);
    }
}
