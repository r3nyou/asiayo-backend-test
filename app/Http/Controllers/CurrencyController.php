<?php

namespace App\Http\Controllers;

use App\Currency\Currency;
use App\Exceptions\CurrencyException;
use App\Http\Requests\CurrencyRequest;
use Exception;

class CurrencyController extends Controller
{
    public function convert(CurrencyRequest $request)
    {
        try {
            $result = (new Currency(config('forexrate.currencies')))
                ->amount($request->amount)
                ->from($request->from)
                ->to($request->to)
                ->get();
        } catch (Exception $e) {
            throw new CurrencyException($e->getMessage());
        }

        return response([
            'from' => $request->from,
            'to' => $request->to,
            'amount' => $request->amount,
            'result' => $result,
        ], 200);
    }
}
