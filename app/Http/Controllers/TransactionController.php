<?php

namespace App\Http\Controllers;

use App\Services\Transaction\CreateTransaction\Service as CreateTransactionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
    public function createTransaction(Request $request, $user_id): JsonResponse
    {
        $data = array_merge($request->toArray(), [
            'user_id' => $user_id,
        ]);

        $validateData = Validator::make($data, [
            'user_id'             => 'numeric',
            'type'                => 'required|in:debit,replenishment,transfer',
            'amount'              => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'destination_user_id' => 'numeric',
        ], [
            'user_id.numeric'             => 'Id пользователя должен быть числом',
            'type.required'               => 'Тип транзакции обязательный параметр',
            'type.in'                     => 'Не верный тип транзакции',
            'amount.required'             => 'Сумма обязательный параметр',
            'amount.numeric'              => 'Сумма должна быть числом с плавающей точкой',
            'amount.regex'                => 'Сумма должна быть числом с плавающей точкой',
            'destination_user_id.numeric' => 'Id целевой учетной записи должен быть числом',
        ]);

        if ($validateData->fails()) {
            return response()->json([
                'message' => $validateData->errors()->first(),
            ], 422);
        }

        $service = new CreateTransactionService;
        $result  = $service->execute($data, $data['type']);
    }
}
