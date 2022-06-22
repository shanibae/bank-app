<?php

namespace App\Http\Controllers\Bank;

use App\Http\Controllers\Controller;
use App\Transaction;
use App\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

/**
 * Class BankingController
 * @package App\Http\Controllers\Bank
 */
class BankingController extends Controller
{
    /**
     * @return Factory|View
     */
    public function deposit()
    {
        return view('bank.deposit');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function depositMoney(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required',
        ]);

        if (!$validator->fails()) {
            $userId = Auth::user()->id;
            $transaction = Transaction::where('user_id', $userId)->orderBy('created_at', 'desc')->first();
            $balance = $transaction ? $transaction->balance : 0;
            $amount = $request->input('amount');
            Transaction::create([
                'user_id' => $userId,
                'amount' => $amount,
                'balance' => $balance + $amount,
                'type_id' => $request->input('type'), //please do seeding,  1 for credit and 2 for debit
                'details' => 'Deposit'
            ]);

            return redirect()->route('deposit')->with('status', 'Deposit successfully');
        } else
            return redirect()->route('deposit');
    }

    /**
     * @return Factory|View
     */
    public function withdraw()
    {
        return view('bank.withdraw');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function withdrawMoney(Request $request)
    {
        $validator = Validator::make($request->all(), ['amount' => 'required']);

        if (!$validator->fails()) {
            $amount = $request->input('amount');
            $userId = auth()->user()->id;
            $transaction = Transaction::where('user_id', $userId)->orderBy('created_at', 'desc')->first();
            $balance = $transaction ? $transaction->balance : 0;

            if ($amount && $amount <= $balance) {
                Transaction::create([
                    'user_id' => $userId,
                    'amount' => $amount,
                    'balance' => $balance - $amount,
                    'type_id' => $request->input('type'), //please do seeding,  1 for credit and 2 for debit
                    'details' => 'Withdraw'
                ]);
            } else {
                return redirect()->route('withdraw')->with('invalid', 'Insufficient Amount ');
            }

            return redirect()->route('withdraw')->with('status', 'Withdraw successfully');
        }

        return redirect()->route('withdraw');
    }

    /**
     * @return Factory|View
     */
    public function transfer()
    {
        return view('bank.transfer');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function transferMoney(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required',
            'email' => 'required|string|email|max:255',
        ]);

        if (!$validator->fails()) {
            $amount = $request->input('amount');
            $user = auth()->user();
            $transaction = Transaction::where('user_id', $user->id)->orderBy('created_at', 'desc')->first();
            $balance = $transaction ? $transaction->balance : 0;
            $transferUser = User::where('email', $request->input('email'))->first();
            $transferUserTransaction = Transaction::where('user_id', $transferUser->id)->orderBy('created_at', 'desc')->first();
            $transferUserBalance = $transferUserTransaction ? $transferUserTransaction->balance : 0;

            if ($amount && $amount <= $balance) {

                DB::transaction(function () use ($balance, $user, $request, $transferUserBalance, $amount, $transferUser) {
                    Transaction::create([
                        'user_id' => $transferUser->id,
                        'amount' => $amount,
                        'balance' => $transferUserBalance + $amount,
                        'type_id' => $request->input('type'), //please do seeding,  1 for credit and 2 for debit
                        'details' => 'Transfer from ' . $user->email
                    ]);
                    Transaction::create([
                        'user_id' => $user->id,
                        'amount' => $amount,
                        'balance' => $balance - $amount,
                        'type_id' => 2, //please do seeding,  1 for credit and 2 for debit
                        'details' => 'Transfer To ' . $transferUser->email

                    ]);
                });

            } else {
                return redirect()->route('transfer')->with('invalid', 'Insufficient Amount to transfer');
            }

            return redirect()->route('transfer')->with('status', 'Transfer successfully');
        }

        return redirect()->route('transfer');
    }

    /**
     * @return Factory|View
     */
    public function statement()
    {
        $userId = Auth::user()->id;
        $data = [
            'statements' => Transaction::with(['user', 'transactionType'])->where('user_id', $userId)->paginate(10),
        ];

        return view('bank.statement', $data);
    }
}
