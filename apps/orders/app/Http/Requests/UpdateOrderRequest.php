<?php

namespace App\Http\Requests;

use App\Enums\OrderStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

class UpdateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    #[Pure]
    #[ArrayShape(["status" => "array"])]
    public function rules(): array
    {
        return [
            "status" => ['required', 'string', new Enum(OrderStatusEnum::class)],
        ];
    }
}
