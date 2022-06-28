<?php

namespace App\Http\Controllers\v1;

use App\Enums\OrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\OrderService;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class OrdersController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Order::class, 'order');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $data = $request->validate([
            'search' => ['nullable', 'string', 'required_with:searchBy'],
            'searchBy' => ['nullable', 'string', 'required_with:search', Rule::in(['id', 'tracking_number'])],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        try {
            $orders = Order::when(Arr::get($data, 'search', false), function (Builder $query) use ($data) {
                return $query->where($data['searchBy'], $data['search']);
            })
                ->with(['subscriptions', 'subscriptions.subscribable'])
                ->paginate(Arr::get($request->all(), 'per_page', 15));
            return $this->successResponse(
                new OrderCollection(
                    $orders
                )
            );
        } catch (Exception $e) {
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
        } catch (Exception $e) {
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
        $data = $request->validated();
        try {
            (new OrderService($order))->assignData(
                OrderStatusEnum::from($data['status'])
            );

            return $this->successResponse(
                new OrderResource($order)
            );

        } catch (Exception $e) {
            $this->reportError($e);
            return $this->errorResponse(__('messages.Something went wrong'), ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
