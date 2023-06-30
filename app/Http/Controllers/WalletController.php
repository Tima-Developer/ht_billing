<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Контроллер кошелька
 */
class WalletController extends Controller
{
    /**
     * Возвращает баланс пользователя
     *
     * @param  \Illuminate\Http\Request      $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBalance(Request $request): JsonResponse
    {

    }
}
