<?php

namespace App\Http\Controllers;

use App\Helper\ResponseJson;
use App\Models\Order;
use App\Services\BankTransactionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\ExpectationFailedException;
use function request as request;

class OrderController extends Controller
{


    public function add(Request $request)
    {
        // add new user
        $rules = [
            'product_ids' => 'required|array',
            'product_ids.*' => 'exists:products,id',
            'payment_type' => 'required|in:credit,gateway'
        ];

        $validated = $this->validate($request, $rules);


        $order = auth()->user()->orders()->create();

        foreach ($validated['product_ids'] as $id)
            $order->products()->attach($id);


        $order->calculatePrice();

        if (request('payment_type') == 'credit') {

            $result = app(BankTransactionService::class)->withdraw(
                auth()->user(),
                $order->price,
                'Order paid'
            );
            if ($result) {
                $order->status = 'paid';
                $order->save();
                return ResponseJson::success("order paid");
            } else {
                return ResponseJson::failure("your credit card is not charged enough");
            }

        }


        $response = Http::post('https://pay.ir/pg/send', [
            'api' => 'test',
            'redirect' => route('pay_back'),
            'amount' => $order->price
        ]);

        if ($response->ok() && $response->json()['status'] == 1) {
            $token = $response->json()['token'];
            $order->payment_token = $token;
            $order->save();
            return redirect('https://pay.ir/pg/' . $token);
        } else {
            return ResponseJson::failure("Something went wrong", $order);
        }
    }

    public function payBack()
    {
        $status = request('status');
        $token = request('token');

        $order = Order::where('payment_token', $token)->first();
        if ($order && $status == 1) {

            $order->status = 'paid';
            $order->save();
        }

        return view('payment', compact('status'));
    }


}
