<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

class ExchangeRateController extends Controller
{

    const EXCHANGE_RATES = [
        'TWD' => [
            'TWD' => 1,
            'JPY' => 3.669,
            'USD' => 0.03281,
        ],
        'JPY' => [
            'TWD' => 0.26956,
            'JPY' => 1,
            'USD' => 0.00885,
        ],
        'USD' => [
            'TWD' => 30.444,
            'JPY' => 111.801,
            'USD' => 1,
        ],
    ];

    public function convert(Request $request)
    {
        //驗證
        $validator = Validator::make($request->all(), [
            'source' => 'required|in:USD,JPY,TWD',
            'target' => 'required|in:USD,JPY,TWD',
            'amount' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        $source = $request->input('source');
        $target = $request->input('target');
        $amount = $request->input('amount');
        $amount = preg_replace('/[^0-9.]/', '', $amount);
        $amount = floatval($amount);

        //檢查
        if (empty(static::EXCHANGE_RATES[strtoupper($source)])) {

            return response()->json(['error' => 'Invalid currency'], 400);
        }

        if (empty(static::EXCHANGE_RATES[strtoupper($target)])) {

            return response()->json(['error' => 'Invalid target'], 400);
        }

        $exchangeRate = static::EXCHANGE_RATES[$source][$target] ?? '';

        if (empty($exchangeRate)) {

            return response()->json(['error' => 'Invalid exchangeRate'], 400);
        }

        //實際轉換
        $convertedAmount = round($amount * $exchangeRate, 2);

        return response()
            ->json(
                [
                    'msg' => 'success',
                    'amount' => '$' . number_format($convertedAmount, 2, '.', ','),
                ]
            );
    }
}
