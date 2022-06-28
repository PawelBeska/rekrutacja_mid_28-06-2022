<?php

namespace App\Http\Requests;

use App\Enums\OrderStatusEnum;
use App\Enums\OrderSubscriptionTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateOrderSubscriptionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "type" => ['required', 'string', new Enum(OrderSubscriptionTypeEnum::class)],
            "subscribed" => ['required', 'boolean'],
        ];
    }
}
