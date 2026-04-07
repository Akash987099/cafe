<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Notification;
use App\Models\Address;

class UserController extends Controller
{
    protected $user;
    protected $address;

    public function __construct()
    {
        $this->user = new User();
        $this->address = new Address();
    }

    public function addAddress(Request $request)
    {
        dd($request->all());
    }

    public function walletPoints()
    {
        $user = auth()->user();

        return response()->json([
            'status' => true,
            'points' => $user->wallet_points,
        ]);
    }

    public function notifications()
    {
        $user = auth()->user();

        $notification = Notification::where('user_id', $user->id)->select('id', 'title', 'description')->get();

        return response()->json([
            'status' => true,
            'notifications' => $notification,
        ]);
    }

    public function notificationDetails($id)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized user',
            ], 401);
        }

        $notification = Notification::where('user_id', $user->id)
            ->where('id', $id)
            ->select('id', 'title', 'description', 'is_read')
            ->first();

        if (!$notification) {
            return response()->json([
                'status' => false,
                'message' => 'Notification not found',
            ], 404);
        }

        if ($notification->is_read == 0) {
            $notification->update(['is_read' => 1]);
        }

        return response()->json([
            'status' => true,
            'notification' => $notification,
        ], 200);
    }
}
