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
            $arrayResult[] = [
                'testLocation' => $result->testLocation(),
                'exception' => $result->exception() ? $result->exception()->getMessage() : '',
                'response' => $result->response() ? $result->response()->content() : '',
                'requestUrl' => $result->requestUrl(),
            ];

            foreach ($result->expectationResults() as $expectation) {
                $arrayResult['expectationResults'][] = [
                    'satisfied' => $expectation->satisfied(),
                    'label' => $expectation->label(),
                    'message' => $expectation->message(),
                ];
            }
        }

        return json_encode(array_values($arrayResult), JSON_THROW_ON_ERROR);
    }

}