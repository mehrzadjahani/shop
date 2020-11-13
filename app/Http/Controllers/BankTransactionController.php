<?php

namespace App\Http\Controllers;

use App\Helper\ResponseJson;
use App\Models\Order;
use App\Models\User;
use App\Models\UserPaymentTokens;
use App\Services\BankTransactionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use function request as request;

class BankTransactionController extends Controller
{


    public function addCredit(Request $request)
    {
        $rules = [
            'amount' => 'required|int|min:10000',
        ];

        $validated = $this->validate($request, $rules);


        $response = Http::post('https://pay.ir/pg/send', [
            'api' => 'test',
            'redirect' => route('user_pay_back'),
            'amount' => $validated['amount'],
        ]);

        if ($response->ok() && $response->json()['status'] == 1) {
            $token = $response->json()['token'];

            auth()->user()->payments()->create([
                'amount' => $validated['amount'],
                'token' => $token
            ]);

            return redirect('https://pay.ir/pg/' . $token);
        } else {
            return ResponseJson::failure("Something went wrong");
        }
    }

    public function creditAmount()
    {
        return auth()->user()->lastTransaction()->sum?? 0;
    }
    public function payBack()
    {
        $token = request('token');
        $response = Http::post('https://pay.ir/pg/verify', ['api' => 'test', 'token' => $token]);
        $status = 0;
        if ($response->ok() && $response->json()['status'] == 1) {
            $status = $response->json()['status'];
            $user_payment_token = UserPaymentTokens::where('token', $token)->first();
            if ($user_payment_token && $status == 1 && !$user_payment_token->confirmed) {

                $user_payment_token->confirmed = 1;
                $user_payment_token->save();
                $last_transaction = $user_payment_token->user->lastTransaction();
                app(BankTransactionService::class)->deposit(
                    $user_payment_token->user,
                    $user_payment_token->amount,
                    'User charged its credit'
                );
            }
        }

        return view('payment', compact('status'));
    }


}
