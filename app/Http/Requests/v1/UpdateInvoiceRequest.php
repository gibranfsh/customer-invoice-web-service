<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();

        return $user !== null && $user->tokenCan('update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $method = $this->method();

        if ($method === 'PUT') {
            return [
                'customer_id' => ['required', 'exists:customers,id'],
                'amount' => ['required', 'numeric'],
                'status' => ['required', Rule::in(['Void', 'Billed', 'Paid'])],
                'billedDate' => ['required', 'date'],
                'paidDate' => ['sometimes', 'date'],
            ];
        } else { // assume that $method === 'PATCH'
            return [
                'customer_id' => ['sometimes', 'required', 'exists:customers,id'],
                'amount' => ['sometimes', 'required', 'numeric'],
                'status' => ['sometimes', 'required', Rule::in(['Void', 'Billed', 'Paid'])],
                'billedDate' => ['sometimes', 'required', 'date'],
                'paidDate' => ['sometimes', 'date'],
            ];
        }
    }
}
