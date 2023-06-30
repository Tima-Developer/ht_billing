<?php

namespace App\Services\Transaction\CreateTransaction;

use App\Models\Transaction;

/**
 * Сервисный класс для обработки транзакций
 */
class Service
{
    private const TYPE_MAPPER = [
        Transaction::TYPE_DEBIT         => Processors\Debit::class,
        Transaction::TYPE_REPLENISHMENT => Processors\Replenishment::class,
        Transaction::TYPE_TRANSFER      => Processors\Transfer::class,
    ];

    /**
     * Выполняет транзакцию
     *
     * @param  array                                              $params
     * @param  string                                             $type
     * @return \App\Services\Transaction\CreateTransaction\Result
     */
    public function execute(array $params, string $type): Result
    {
        $processorClass = self::TYPE_MAPPER[$type] ?? null;

        if ($processorClass === null) {
            return new Result(['message' => 'Тип транзакции не найден'], 400);
        }

        $processor = new $processorClass;
        return $processor->execute($params);
    }
}
