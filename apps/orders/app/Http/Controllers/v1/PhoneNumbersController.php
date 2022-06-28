<?php

namespace App\Http\Controllers\v1;


use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\PhoneNumber;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class PhoneNumbersController  extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(PhoneNumber::class, 'order');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            return $this->successResponse(
                new \App\Http\Resources\OrderCollection(
                    Order::paginate(Arr::get($request->all(), 'per_page', 15))
                )
            );
        } catch (\Exception $e) {
            $this->reportError($e);
            return $this->errorResponse(__('messages.Something went wrong'), ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, Order $order): JsonResponse
    {
        try {
            $order->load(['subscriptions', 'subscriptions.subscribable']);
            return $this->successResponse(
                new OrderResource($order)
            );
        } catch (\Exception $e) {
            $this->reportError($e);
            return $this->errorResponse(__('messages.Something went wrong'), ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param \App\Http\Requests\UpdateOrderRequest $request
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateOrderRequest $request, Order $order): JsonResponse
    {

    }
}
