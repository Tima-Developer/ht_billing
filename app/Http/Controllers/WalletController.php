<?php

namespace App\Http\Controllers;

use App\Services\Wallet\GetBalance\Service;
use AshAllenDesign\LaravelExchangeRates\Facades\ExchangeRate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
    public function getBalance(Request $request, $user_id): JsonResponse
    {
        $validateData = Validator::make([
            'user_id' => $user_id,
        ], [
            'user_id'      => 'required|numeric|exists:wallets,user_id',
        ], [
            'user_id.required'     => 'Id пользователя обязательный параметр',
            'user_id.numeric'      => 'Id пользователя должен быть числом',
            'user_id.exists'       => 'Пользователь не найден',
        ]);

        if ($validateData->fails()) {
            return response()->json([
                'message' => $validateData->errors()->first(),
            ], 422);
        }

        if (!empty($request['currency']) && !in_array($request['currency'], ExchangeRate::currencies())) {
            return response()->json(['message' => 'Валюта не найдена'], 422);
        }

        $service = new Service();
        $result  = $service->execute($user_id, $request['currency']);

        return response()->json(['balance' => $result]);
    }
}
