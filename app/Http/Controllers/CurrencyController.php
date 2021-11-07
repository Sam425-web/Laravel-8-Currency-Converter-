<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use AmrShawky\LaravelCurrency\Facade\Currency;


class CurrencyController extends Controller
{
    public function index()
    {
       return view('index',['names' => Currency::rates()->latest()->get()]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'numeric',
            'from' => 'required',
            'to' => 'required'
        ]);

        $currency = Currency::convert()
        ->from($request->from)
        ->to($request->to)
        ->amount($request->amount)
        ->round(2)
        ->get();

        return back()->with([
            'conversion' => $request->amount . ' ' . $request->from . ' is equal to ' . $currency . ' ' . $request->to,
            'amount' => $request->amount,
            'from' => $request->from,
            'to' => $request->to
        ]);
    }
}
