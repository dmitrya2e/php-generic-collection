<?php

namespace DA2E\GenericCollection\Test;

trait TypeDataProviderTrait
{
    public function scalarDataProvider(): array
    {
        return
            $this->stringDataProvider() +
            $this->floatDataProvider() +
            $this->intDataProvider() +
            $this->numericDataProvider() +
            $this->boolDataProvider();
    }

    public function resourceDataProvider(): array
    {
        $resource = curl_init();
        curl_setopt($resource, CURLOPT_PRIVATE, serialize([]));

        return [
            'resource from curl' => [$resource],
        ];
    }

    public function nullDataProvider(): array
    {
        return [
            'null' => [null],
        ];
    }

    public function stringDataProvider(): array
    {
        return [
            'string "scalar"' => ['scalar'],
            'string empty'    => [''],
        ];
    }

    public function floatDataProvider(): array
    {
        return [
            'float 1.1' => [1.1],
        ];
    }

    public function intDataProvider(): array
    {
        return [
            'int 1'  => [1],
            'int 0'  => [0],
            'int -1' => [-1],
        ];
    }

    public function numericDataProvider(): array
    {
        return [
            'numeric string float' => ['1.23'],
            'numeric string int'   => ['1'],
        ];
    }

    public function boolDataProvider(): array
    {
        return [
            'bool true'  => [true],
            'bool false' => [false],
        ];
    }

    public function callableDataProvider(): array
    {
        return [
            'lambda function' => [
                function () {
                },
            ],
        ];
    }

    public function objectDataProvider(): array
    {
        return [
            'stdClass' => [new \stdClass()],
        ];
    }

    public function arrayDataProvider(): array
    {
        return [['empty array' => []]];
    }
}
