<?php

namespace App\Services\Transaction\CreateTransaction;

/**
 * Результат выполнения сервиса
 */
class Result
{
    /**
     * @var array
     */
    private array $message;

    /**
     * @var int
     */
    private int $status;

    /**
     * @param array $message
     * @param int   $status
     */
    public function __construct(array $message, int $status)
    {
        $this->message = $message;
        $this->status  = $status;
    }

    /**
     * Возвращает сообщение результата работы
     *
     * @return array
     */
    public function getMessage(): array
    {
        return $this->message;
    }

    /**
     * Возвращает статус запроса
     *
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }
}
