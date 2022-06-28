<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrderSubscriptionCollection;
use App\Http\Resources\OrderSubscriptionResource;
use App\Models\Order;
use App\Models\OrderSubscription;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class OrderSubscriptionsController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Order::class, 'order');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, Order $order): JsonResponse
    {
        try {
            return $this->successResponse(
                new OrderSubscriptionCollection(
                    $order->subscriptions()->paginate(Arr::get($request->all(), 'per_page', 15))
                )
            );
        } catch (\Exception $e) {
            $this->reportError($e);
            return $this->errorResponse(__('messages.Something went wrong'), ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\OrderSubscription $orderSubscription
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, OrderSubscription $orderSubscription): JsonResponse
    {
        try {
            $orderSubscription->load(['subscribable']);
            return $this->successResponse(
                new OrderSubscriptionResource($orderSubscription)
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
