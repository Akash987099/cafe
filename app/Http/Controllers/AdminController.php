<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;

class AdminController extends Controller
{
    protected $user;
    protected $order;

    public function __construct()
    {
        $this->user = new User();
        $this->order = new Order();
    }

    public function index()
    {
        $todayUsers = $this->user->whereDate('created_at', now()->toDateString())->count();
        $totalUsers = $this->user->count();

        $todayOrders = $this->order->whereDate('created_at', now()->toDateString())->count();
        $totalOrders = $this->order->count();

        return view('welcome', compact(
            'todayUsers',
            'totalUsers',
            'todayOrders',
            'totalOrders',
            ));
    }
}
