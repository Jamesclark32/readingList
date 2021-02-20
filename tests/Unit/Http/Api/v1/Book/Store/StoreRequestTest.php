<?php

namespace Tests\Unit\Http\Api\v1\Book\Store;

use App\Http\Controllers\Api\V1\Books\StoreController;
use App\Http\Requests\Api\V1\Books\StoreRequest;
use Tests\Unit\TestsRequestValidation;
use Tests\TestCase;

class StoreRequestTest extends TestCase
{
    use TestsRequestValidation;

    public function test_store_validates_using_form_request()
    {
        $this->assertActionUsesFormRequest(StoreController::class, StoreRequest::class);
    }

    public function test_validation_matches_expected_rules()
    {
        $request = new StoreRequest();
        $resolvedValidationRules = $request->rules();
        $this->assertEquals($this->getExpectedRules(), $resolvedValidationRules);
    }

    protected function getExpectedRules(): array
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
        ];
    }
}
