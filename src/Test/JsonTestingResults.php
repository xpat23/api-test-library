<?php

declare(strict_types=1);

namespace Xpat\ApiTest\Test;

readonly class JsonTestingResults
{
    public function __construct(private TestingResults $results)
    {
    }

    public function json(): string
    {
        $arrayResult = [];

        foreach ($this->results->all() as $result) {
            $itemResult = [
                'testLocation' => $result->testLocation(),
                'exception' => $result->exception() ? $result->exception()->getMessage() : '',
                'response' => $result->response() ? $result->response()->content() : '',
                'requestUrl' => $result->requestUrl(),
            ];

            foreach ($result->expectationResults() as $expectation) {
                $itemResult['expectationResults'][] = [
                    'satisfied' => $expectation->satisfied(),
                    'label' => $expectation->label(),
                    'message' => $expectation->message(),
                ];
            }

            $arrayResult[] = $itemResult;
        }

        return json_encode($arrayResult, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
    }

}