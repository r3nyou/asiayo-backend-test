<?php

namespace App\Http\Controllers;

use App\Currency\Currency;
use App\Http\Requests\CurrencyRequest;

class CurrencyController extends Controller
{
    public function convert(CurrencyRequest $request)
    {
        $result = (new Currency(config('forexrate.currencies')))
            ->amount($request->amount)
            ->from($request->from)
            ->to($request->to)
            ->get();

        return response([
            'from' => $request->from,
            'to' => $request->to,
            'amount' => $request->amount,
            'result' => $result,
        ], 200);
    }
}
