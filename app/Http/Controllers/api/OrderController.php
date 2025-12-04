<?php

namespace App\Http\Controllers\api;

use App\Constants\DeliveryMethod;
use App\Constants\OrderStatus;
use App\Constants\PaymentStatus;
use App\Constants\SortInOrder;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderShipping;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Resources\Order as OrderResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $orders = Order::orderBy("created_at", SortInOrder::DESC)->paginate(10);
            return OrderResource::collection($orders);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $items = $validatedData['items'];
            $productIds = collect($items)->pluck('product_id')->unique();

            $order = DB::transaction(function () use ($validatedData, $items, $productIds) {
                $products = Product::whereIn('id', $productIds)->lockForUpdate()->get()->keyBy('id');

                $subTotal = collect(($items))->sum(fn($i) => $i['unit_price'] * $i['quantity']);
                $shippingCost = 15;
                $totalAmount = $subTotal + $shippingCost;

                $order = Order::create([
                    'user_id' => $validatedData['user_id'],
                    'order_code' => 'ORD' . strtoupper(uniqid()),
                    'recipient_name' => $validatedData['recipient_name'],
                    'recipient_phone' => $validatedData['recipient_phone'],
                    'recipient_address' => $validatedData['recipient_address'],
                    'subtotal_amount' => $subTotal,
                    'total_amount' => $totalAmount,
                    'payment_method' => $validatedData['payment_method'],
                    'order_status' => OrderStatus::PENDING,
                    'payment_status' => PaymentStatus::PENDING,
                ]);

                OrderShipping::create([
                    'order_id' => $order->id,
                    'shipping_method' => $validatedData['shipping_method'] ?? DeliveryMethod::STANDARD,
                    'shipping_cost' => $shippingCost,
                ]);

                $details = [];
                foreach ($items as $item) {
                    $product = $products[$item['product_id']];
                    $details[] = [
                        'order_id' => $order->id,
                        'snapshot_product_name' => $product->product_name,
                        'snapshot_product_sku' => $product->sku,
                        'snapshot_product_price' => $item['unit_price'],
                        'product_id' => $product->id,
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['unit_price'],
                        'total_price' => $item['unit_price'] * $item['quantity'],
                    ];

                    $stockUpdates[$product->id] = ($stockUpdates[$product->id] ?? 0) + $item['quantity'];
                }

                OrderDetail::insert($details);

                if (!empty($stockUpdates)) {
                    $cases = '';
                    $soldCases = '';
                    $ids = array_keys($stockUpdates);

                    foreach ($stockUpdates as $id => $quantity) {
                        $cases .= "WHEN id = {$id} THEN quantity_in_stock - {$quantity} ";
                        $soldCases .= "WHEN id = {$id} THEN sold_count + {$quantity} ";
                    }

                    DB::statement("
                        UPDATE products
                        SET quantity_in_stock = CASE {$cases} END,
                            sold_count = CASE {$soldCases} END
                        WHERE id IN (" . implode(',', $ids) . ")
                    ");
                }

                return $order;
            });

            $order->load('orderDetails.product', 'user');

            return response()->json([
                'success' => true,
                'message' => 'Order created successfully',
                'data' => new OrderResource($order)
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create order: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $order = Order::findOrFail($id);
            return OrderResource::make($order);
        } catch (ModelNotFoundException $e) {
            return response()->json(["message" => "Order Not Found"], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $order = Order::findOrFail($id);

            $validatedData = $request->validate([
                'order_status' => 'sometimes|string',
                'payment_status' => 'sometimes|string',
            ]);

            $order->update($validatedData);
            return response()->json([
                'success' => true,
                'message' => 'Order updated successfully',
                'data' => new OrderResource($order)
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
