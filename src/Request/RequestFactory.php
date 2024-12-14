<?php

declare(strict_types=1);

namespace Xpat\ApiTest\Request;

use Xpat\Http\Request\HttpRequest;

interface RequestFactory
{
    public function get(string $path, array $headers = []): HttpRequest;

    public function post(string $path, array $data, array $headers = []): HttpRequest;

    public function put(string $path, array $data, array $headers = []): HttpRequest;

    public function delete(string $path, array $headers = []): HttpRequest;
}