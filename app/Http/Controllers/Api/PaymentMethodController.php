<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;

class PaymentMethodController extends Controller
{
    protected $paymentMethod;

    public function index()
    {
        $paymentMethod = PaymentMethod::select('id', 'name', 'label', 'description', 'icon', 'badge', 'status')
            ->orderBy('status', 'desc')
            ->get();

        $user = auth()->user();
        // dd($user);

        foreach ($paymentMethod as $method) {

            if ($method->name == 'wallet') {

                $method->badge = 'You have ₹' . ($user->wallet_points ?? 0) . ' in your wallet';
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Payment Methods',
            'data' => $paymentMethod
        ]);
    }
}
