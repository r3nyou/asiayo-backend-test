<?php

namespace App\Http\Controllers;

use App\Currency\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function convert(Request $request)
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
