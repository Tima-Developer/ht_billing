<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Контроллер траназакции
 */
class TransactionController extends Controller
{
    /**
     * Совершаем транзакцию
     *
     * @param  \Illuminate\Http\Request      $request
     * @param  int                           $user_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function createTransaction(Request $request, int $user_id): JsonResponse
    {

    }
}
