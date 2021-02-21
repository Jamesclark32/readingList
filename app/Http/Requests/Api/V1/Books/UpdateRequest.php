<?php

namespace App\Http\Requests\Api\V1\Books;

class UpdateRequest extends Request
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
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
            ],
            'author' => [
                'nullable',
                'string',
            ],
            'isbn' => [
                'nullable',
                'string',
            ],
            'read_sequence' => [
                'integer',
            ],
        ];
    }
}
