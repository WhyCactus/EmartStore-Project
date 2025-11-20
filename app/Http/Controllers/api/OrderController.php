<?php

namespace App\Http\Controllers\api;

use App\Constants\OrderStatus;
use App\Constants\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\OrderDetail;
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
            $orders = Order::orderBy("created_at", "desc")->paginate(10);
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
            $validated = $request->validated();

            foreach ($validated['items'] as $item) {
                $product = Product::find($item['product_id']);
                if (!$product) {
                    return response()->json([
                        'success' => false,
                        'message' => "Product ID {$item['product_id']} not found",
                    ], 404);
                }

                if ($product->quantity_in_stock < $item['quantity']) {
                    return response()->json([
                        'success' => false,
                        'message' => "Insufficient stock for product: {$product->product_name}. Available: {$product->quantity_in_stock}",
                    ], 400);
                }
            }

            $order = DB::transaction(function () use ($validated) {
                $subtotalAmount = 0;
                $totalAmount = 0;
                foreach ($validated['items'] as $item) {
                    $subtotalAmount += $item['unit_price'] * $item['quantity'];
                }

                $shippingFee = 15;
                $totalAmount = $subtotalAmount + $shippingFee;

                $order = Order::create([
                    'user_id' => $validated['user_id'],
                    'order_code' => 'ORD-' . strtoupper(uniqid()),
                    'recipient_name' => $validated['recipient_name'],
                    'recipient_phone' => $validated['recipient_phone'],
                    'recipient_address' => $validated['recipient_address'],
                    'subtotal_amount' => $subtotalAmount,
                    'total_amount' => $totalAmount,
                    'payment_method' => $validated['payment_method'],
                    'payment_status' => PaymentStatus::PENDING,
                    'order_status' => OrderStatus::PENDING,
                ]);

                foreach ($validated['items'] as $item) {
                    OrderDetail::create([
                        'order_id' => $order->id,
                        'snapshot_product_name' => Product::find($item['product_id'])->product_name,
                        'snapshot_product_sku' => Product::find($item['product_id'])->sku,
                        'snapshot_product_price' => Product::find($item['product_id'])->discounted_price,
                        'snapshot_variant_attributes' => null,
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['unit_price'],
                        'total_price' => $item['unit_price'] * $item['quantity'],
                    ]);

                    $product = Product::find($item['product_id']);
                    $product->quantity_in_stock -= $item['quantity'];
                    $product->sold_count += $item['quantity'];
                    $product->save();
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

            $validated = $request->validate([
                'order_status' => 'sometimes|string',
                'payment_status' => 'sometimes|string',
            ]);

            $order->update($validated);
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
