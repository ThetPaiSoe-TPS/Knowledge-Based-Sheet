<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class OrderItemsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_name'=> 'required|max:255|string',
            'quantity' => 'required|integer|min:1',
            'price'=> 'required|numeric|min:0',
            'total'=> 'required|numeric|min:0',
            'order_id'=> 'required|exists:orders,id'
        ];
    }
}
