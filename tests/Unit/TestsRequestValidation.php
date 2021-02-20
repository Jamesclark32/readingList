<?php

namespace Tests\Unit;

use PHPUnit\Framework\Assert as PHPUnitAssert;

trait TestsRequestValidation
{
    public function assertActionUsesFormRequest(string $controller, string $form_request)
    {
        PHPUnitAssert::assertTrue(is_subclass_of($form_request, 'Illuminate\\Foundation\\Http\\FormRequest'),
            $form_request.' is not a type of Form Request');

        try {
            $reflector = new \ReflectionClass($controller);
            $action = $reflector->getMethod('__invoke');
        } catch (\ReflectionException $exception) {
            PHPUnitAssert::fail('Controller action could not be found: '.$controller.'@__invoke');
        }

        PHPUnitAssert::assertTrue($action->isPublic(),
            'Action __invoke is not public, controller actions must be public.');

        $actual = collect($action->getParameters())->contains(function ($parameter) use ($form_request) {
            return $parameter->getType() instanceof \ReflectionNamedType && $parameter->getType()->getName() === $form_request;
        });

        PHPUnitAssert::assertTrue($actual,
            'Action __invoke does not have validation using the "'.$form_request.'" Form Request.');
    }
}