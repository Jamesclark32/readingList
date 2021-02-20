<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class Request extends FormRequest
{
    /**
     * Override the default failedValidation behavior
     * to return json representation of validation errors
     * rather than redirecting back().
     *
     * @param  Validator  $validator
     *
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator): void
    {
        $errorResponse = response()->json(['errors' => $validator->errors()], 422);

        throw new ValidationException($validator, $errorResponse);
    }
}