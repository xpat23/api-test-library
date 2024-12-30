# API Test Library

## Description

This PHP library is designed for testing JSON API endpoints.

## Requirements

- PHP >= 8.3
- ext-curl
- Composer

## Installation

To install the library, use Composer:

```bash
composer require xpat/api-test-library
```

## Usage

To run the API tests, use the provided script. You can specify the path to the test cases as an argument. If no path is provided, it defaults to the current directory.
In the example below we are using symfony dependency injection container to load the services.yaml file.

```php
#!/usr/bin/env php
<?php
declare(strict_types=1);

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Xpat\ApiTest\Attribute\Test;
use Xpat\ApiTest\FileSystem\ClassesByPath;
use Xpat\ApiTest\FileSystem\MethodsWithAttribute;
use Xpat\ApiTest\FileSystem\PublicMethodsOfClasses;
use Xpat\ApiTest\FileSystem\SubClassesOf;
use Xpat\ApiTest\Output\ResultsOutput;
use Xpat\ApiTest\Test\ApiTestMethods;
use Xpat\ApiTest\Test\TestCase;
use Xpat\ApiTest\Test\TestingResults;

require_once __DIR__ . '/../vendor/autoload.php';

$directory = __DIR__;

$container = new ContainerBuilder();
$loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../config'));
$loader->load('services.yaml');

$path = $argv[1] ?? $directory;

(
new ResultsOutput(
    new TestingResults(
        new ApiTestMethods(
            new MethodsWithAttribute(
                new PublicMethodsOfClasses(
                    new SubClassesOf(
                        new ClassesByPath($path),
                        TestCase::class
                    ),
                ),
                Test::class
            )
        ),
        $container
    )
)
)->print();
```

To execute the script, run:

```bash
php src/api-test /path/to/test/cases
```

Replace `/path/to/test/cases` with the actual path to your test cases. If no path is provided, it will use the current directory.

## License

This library is licensed under the MIT License.