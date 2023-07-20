<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCustomerRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $method = $this->method();

        if ($method === 'PUT') {
            return [
                'name' => ['required'],
                'type' => ['required', Rule::in(['Individual', 'Business'])],
                'email' => ['required', 'email'],
                'phone' => ['required'],
                'address' => ['required'],
                'city' => ['required'],
                'state' => ['required'],
                'zip' => ['required'],
            ];
        } else { // assume that $method === 'PATCH'
            return [
                'name' => ['sometimes', 'required'],
                'type' => ['sometimes', 'required', Rule::in(['Individual', 'Business'])],
                'email' => ['sometimes', 'required', 'email'],
                'phone' => ['sometimes', 'required'],
                'address' => ['sometimes', 'required'],
                'city' => ['sometimes', 'required'],
                'state' => ['sometimes', 'required'],
                'zip' => ['sometimes', 'required'],
            ];
        }
    }
}
