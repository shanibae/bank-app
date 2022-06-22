<?php

namespace App\Http\Controllers;

use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $userID = Auth::user()->id;
        $transaction = Transaction::where('user_id', $userID)->orderBy('created_at', 'desc')->first();
        $data = [
            'balance' =>  $transaction ? $transaction->balance : 0,
        ];

        return view('home', $data);
    }
}
