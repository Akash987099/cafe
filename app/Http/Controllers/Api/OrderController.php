<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Transcation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Address;
use App\Models\TruckOrder;
use App\Models\Review;
use App\Models\OrderRating;


class OrderController extends Controller
{
    protected $order;
    protected $orderItems;
    protected $carts;
    protected $product;
    protected $transcation;
    protected $address;
    protected $track;

    public function __construct()
    {
        $this->order = new Order();
        $this->orderItems = new OrderItem();
        $this->carts = new Cart();
        $this->product = new Product();
        $this->transcation = new Transcation();
        $this->address = new Address();
        $this->track = new TruckOrder();
    }

    public function placeOrder(Request $request)
    {
        $user_id = auth()->id();

        $address = $this->address
            ->where('user_id', $user_id)
            ->where('is_default', 1)
            ->first();

        if (!$address) {
            return response()->json([
                'status' => false,
                'message' => 'Default address not found'
            ], 400);
        }

        $carts = $this->carts
            ->with('product')
            ->where('user_id', $user_id)
            ->whereNull('order_id')
            ->get();

        if ($carts->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Cart is empty'
            ], 400);
        }

        try {
            return DB::transaction(function () use ($carts, $user_id, $request, $address) {

                $totalAmount = 0;
                $totalDiscount = 0;

                foreach ($carts as $cart) {

                    if (!$cart->product) {
                        throw new \Exception("Product missing for cart ID {$cart->id}");
                    }

                    $availableStock = (int) ($cart->product->stock ?? 0);
                    if ($availableStock < (int) $cart->qty) {
                        throw new \Exception("Insufficient stock for {$cart->product->name}");
                    }

                    $totalAmount += $cart->price;
                    $totalDiscount += $cart->discount;
                }

                $finalAmount = $totalAmount - $totalDiscount;

                $orderNo = $this->generateOrderNo();

                $order = $this->order->create([
                    'user_id' => $user_id,
                    'address_id' => $address->id,
                    'order_no' => $orderNo,
                    'total_amount' => $totalAmount,
                    'total_discount' => $totalDiscount,
                    'final_amount' => $finalAmount,
                    'payment_method' => $request->payment_method ?? 'cod',
                    'status' => 'Confirm Order'
                ]);

                foreach ($carts as $cart) {

                    $this->orderItems->create([
                        'order_id' => $order->id,
                        'product_id' => $cart->product_id,
                        'qty' => $cart->qty,
                        'price' => $cart->price,
                        'discount' => $cart->discount,
                        'final_price' => $cart->price - $cart->discount,
                    ]);

                    $cart->product->decrement('stock', $cart->qty);

                    $cart->update([
                        'order_id' => $order->id
                    ]);
                }

                $this->transcation->create([
                    'order_id' => $order->id,
                    'payment_id' => null,
                    'amount' => $finalAmount,
                    'status' => 'Confirm Order'
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'Order placed successfully',
                    'order_id' => $order->id,
                    'order_no' => $orderNo,
                    'final_amount' => $finalAmount,
                    'total_items' => $carts->count()
                ]);
            });
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function index()
    {
        $user_id = auth()->id();

        $orders = Order::with([
            'products:id,name,image',
            'orderRating'
        ])
            ->where('user_id', $user_id)
            ->latest()
            ->get([
                'id',
                'order_no',
                'status',
                'total_amount',
                'final_amount',
                'payment_method',
                'created_at'
            ]);

        return response()->json([
            'status' => true,
            'message' => 'Order list',
            'data' => $orders
        ]);
    }

    public function show($id)
    {
        if (!$id) {
            return response()->json([
                'status' => false,
                'message' => 'Id is required'
            ], 404);
        }

        $user_id = auth()->id();

        $order = $this->order
            ->with(['items.product'])
            ->where('user_id', $user_id)
            ->where('id', $id)
            ->first();

        if (!$order) {
            return response()->json([
                'status' => false,
                'message' => 'Order not found'
            ], 404);
        }

        $order->items->each(function ($item) use ($user_id) {

            if ($item->product) {

                // product url
                $item->product->url = Str::slug($item->product->name) . '-' . $item->product->id;

                // product rating (user rating)
                $rating = Review::where('product_id', $item->product->id)
                    ->where('order_id', $item->order_id)
                    ->where('user_id', $user_id)
                    ->select('rating', 'review')
                    ->first();

                $item->product->rating = $rating ? $rating->rating : null;
                $item->product->review = $rating ? $rating->review : null;
            }
        });

        return response()->json([
            'status' => true,
            'message' => 'Order details',
            'data' => $order
        ]);
    }

    public function cancel($id)
    {
        $user_id = auth()->id();

        $order = $this->order
            ->with('items')
            ->where('user_id', $user_id)
            ->where('id', $id)
            ->first();

        if (!$order) {
            return response()->json([
                'status' => false,
                'message' => 'Order not found'
            ], 404);
        }

        if ($order->status === 'cancelled') {
            return response()->json([
                'status' => false,
                'message' => 'Order already cancelled'
            ]);
        }

        if ($order->status === 'delivered') {
            return response()->json([
                'status' => false,
                'message' => 'Delivered order cannot be cancelled'
            ]);
        }

        DB::transaction(function () use ($order) {

            foreach ($order->items as $item) {
                Product::where('id', $item->product_id)
                    ->increment('stock', $item->qty);
            }

            $order->update([
                'status' => 'cancelled'
            ]);

            DB::table('transactions')
                ->where('order_id', $order->id)
                ->update([
                    'status' => 'cancelled'
                ]);
        });

        return response()->json([
            'status' => true,
            'message' => 'Order cancelled successfully'
        ]);
    }

    private function generateOrderNo()
    {
        do {
            $orderNo = 'AWC' . mt_rand(10000, 99999);
        } while (Order::where('order_no', $orderNo)->exists());

        return $orderNo;
    }

    public function invoice($id)
    {
        $user_id = auth()->id();

        if (!$id) {
            return response()->json([
                'status' => false,
                'message' => 'Id is required'
            ], 404);
        }

        $order = $this->order
            ->with([
                'items' => function ($query) {
                    $query->select('id', 'order_id', 'product_id', 'qty', 'price', 'discount', 'final_price');
                },
                'items.product' => function ($query) {
                    $query->select('id', 'name', 'image', 'sku_code', 'hsn_code', 'barcode_base');
                }
            ])
            ->where('user_id', $user_id)
            ->where('id', $id)
            ->first();

        if (!$order) {
            return response()->json([
                'status' => false,
                'message' => 'Order not found'
            ], 404);
        }

        $transaction = $this->transcation
            ->where('order_id', $order->id)
            ->latest('id')
            ->first();

        $user = auth()->user();

        $defaultAddress = $this->address
            ->where('id', $user->address_id)
            ->where('is_default', 1)
            ->first();

        if (!$defaultAddress) {
            $defaultAddress = $this->address
                ->where('user_id', $user_id)
                ->where('is_default', 1)
                ->first();
        }

        return response()->json([
            'status' => true,
            'message' => 'Invoice details',
            'data' => [
                'order' => [
                    'order_id' => $order->id,
                    'order_no' => $order->order_no,
                    'status' => $order->status,
                    'payment_status' => $order->payment_status,
                    'payment_method' => $order->payment_method,
                    'total_amount' => $order->total_amount,
                    'total_discount' => $order->total_discount,
                    'final_amount' => $order->final_amount,
                    'created_at' => $order->created_at,
                ],
                'items' => $order->items,
                'transaction' => $transaction,
                'address' => $defaultAddress,
            ]
        ]);
    }

    public function track($order_no)
    {
        if (empty($order_no)) {
            return response()->json([
                'status' => false,
                'message' => 'Order Number required'
            ], 400);
        }

        $order = $this->order
            ->where('order_no', $order_no)
            ->first();

        if (!$order) {
            return response()->json([
                'status' => false,
                'message' => 'Order not found'
            ], 404);
        }

        $track = $this->track
            ->where('order_id', $order->id)
            ->orderBy('id', 'ASC')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Tracking details fetched successfully',
            'order' => $order,
            'tracking' => $track
        ], 200);
    }
}
