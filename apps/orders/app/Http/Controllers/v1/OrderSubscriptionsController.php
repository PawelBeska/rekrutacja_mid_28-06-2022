<?php

namespace App\Http\Controllers\v1;

use App\Enums\OrderSubscriptionTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Requests\UpdateOrderSubscriptionRequest;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrderSubscriptionCollection;
use App\Http\Resources\OrderSubscriptionResource;
use App\Models\Order;
use App\Models\OrderSubscription;
use App\Services\OrderSubscriptionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class OrderSubscriptionsController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(OrderSubscription::class, 'subscription');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, Order $order): JsonResponse
    {
        $data = $request->validate([
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        try {
            return $this->successResponse(
                new OrderSubscriptionCollection(
                    $order->subscriptions()->paginate(Arr::get($data, 'per_page', 15))
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
     * @param \App\Models\OrderSubscription $subscription
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, Order $order, OrderSubscription $subscription): JsonResponse
    {
        try {
            $subscription->load(['subscribable']);
            return $this->successResponse(
                new OrderSubscriptionResource($subscription)
            );
        } catch (\Exception $e) {
            $this->reportError($e);
            return $this->errorResponse(__('messages.Something went wrong'), ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param \App\Http\Requests\UpdateOrderSubscriptionRequest $request
     * @param \App\Models\Order $order
     * @param \App\Models\OrderSubscription $subscription
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateOrderSubscriptionRequest $request, Order $order, OrderSubscription $subscription): JsonResponse
    {
        $data = $request->validated();
        try {
            $subscription->load(['subscribable']);
            (new OrderSubscriptionService($subscription))
                ->assignData(
                    $order,
                    $subscription->subscribable,
                    OrderSubscriptionTypeEnum::from($data['type']),
                    $data['subscribed']
                );
            return $this->successResponse(
                new OrderSubscriptionResource($subscription)
            );
        } catch (\Exception $e) {
            $this->reportError($e);
            return $this->errorResponse(__('messages.Something went wrong'), ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
