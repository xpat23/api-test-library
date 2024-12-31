<?php

declare(strict_types=1);

namespace Xpat\ApiTest\Output;

use Xpat\ApiTest\Test\TestingResults;

readonly class ResultsOutput
{
    public function __construct(private TestingResults $results)
    {
    }

    public function print(): void
    {
        $errorsAmount = 0;
        $passedAmount = 0;
        $testLocation = '';

        foreach ($this->results->all() as $result) {
            if ($result->testLocation() !== $testLocation) {
                $testLocation = $result->testLocation();
                echo sprintf("\e[1;37;35m ...... \e[0m \e[0;36m %s \e[0m\n", $result->testLocation());
            }

            if ($result->exception() !== null) {
                echo sprintf(
                    "\e[1;37;31m Failed \e[0m   \e[0;91m    %s \e[0m - \e[0;31m %s\e[0m \n",
                    'Uncaught Exception',
                    $result->exception()->getMessage()
                );
                $errorsAmount++;
                continue;
            }

            echo sprintf("\e[1;37;35m ...... \e[0m \e[0;95m   %s \e[0m\n", $result->requestUrl());

            foreach ($result->expectationResults() as $expectation) {
                if ($expectation->satisfied()) {
                    $passedAmount++;
                    echo sprintf(
                        "\e[1;37;92m Passed \e[0m   \e[0;96m    %s \e[0m\n",
                        $expectation->label()
                    );
                } else {
                    $errorsAmount++;
                    echo sprintf(
                        "\e[1;37;31m Failed \e[0m   \e[0;91m    %s \e[0m - \e[0;31m %s\e[0m \n",
                        $expectation->label(),
                        $expectation->message()
                    );
                }
            }
        }

        echo sprintf("\e[1;37;35m ...... \e[0m \e[0;36m %s \e[0m\n", 'Summary');
        echo sprintf("\e[1;37;35m ...... \e[0m \e[0;36m %s \e[0m\n", 'Total: ' . $passedAmount + $errorsAmount);
        echo sprintf("\e[1;37;35m ...... \e[0m \e[0;36m %s \e[0m\n", 'Passed: ' . $passedAmount);
        echo sprintf("\e[1;37;35m ...... \e[0m \e[0;36m %s \e[0m\n", 'Failed: ' . $errorsAmount);

        if ($errorsAmount > 0) {
            echo "\e[1;37;31m ...... \e[0m \e[1;37;31m Tests failed \e[0m\n";
            exit(1);
        }
    }
}