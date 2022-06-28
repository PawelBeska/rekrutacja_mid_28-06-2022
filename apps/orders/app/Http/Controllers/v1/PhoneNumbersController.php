<?php

namespace App\Http\Controllers\v1;


use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Requests\UpdatePhoneNumberRequest;
use App\Http\Resources\OrderResource;
use App\Http\Resources\PhoneNumberCollection;
use App\Http\Resources\PhoneNumberResource;
use App\Models\Order;
use App\Models\PhoneNumber;
use App\Services\PhoneNumberService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class PhoneNumbersController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(PhoneNumber::class, 'phoneNumber');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $data = $request->validate([
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        try {
            return $this->successResponse(
                new PhoneNumberCollection(
                    PhoneNumber::paginate(Arr::get($data, 'per_page', 15))
                )
            );
        } catch (\Exception $e) {
            $this->reportError($e);
            return $this->errorResponse(__('messages.Something went wrong'), ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PhoneNumber $phoneNumber
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, PhoneNumber $phoneNumber): JsonResponse
    {
        try {
            return $this->successResponse(
                new PhoneNumberResource($phoneNumber)
            );
        } catch (\Exception $e) {
            $this->reportError($e);
            return $this->errorResponse(__('messages.Something went wrong'), ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param \App\Http\Requests\UpdatePhoneNumberRequest $request
     * @param \App\Models\PhoneNumber $phoneNumber
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdatePhoneNumberRequest $request, PhoneNumber $phoneNumber): JsonResponse
    {
        $data = $request->validated();
        try {
            (new PhoneNumberService($phoneNumber))->assignData(
                $data['number']
            );

            return $this->successResponse(
                new PhoneNumberResource($phoneNumber)
            );
        } catch (\Exception $e) {
            $this->reportError($e);
            return $this->errorResponse(__('messages.Something went wrong'), ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


}
