<?php

declare(strict_types=1);

namespace Xpat\ApiTest\Request;

use Xpat\Http\Request\Delete;
use Xpat\Http\Request\Get;
use Xpat\Http\Request\Headers;
use Xpat\Http\Request\HttpRequest;
use Xpat\Http\Request\JsonBody;
use Xpat\Http\Request\Post;
use Xpat\Http\Request\Put;
use Xpat\Http\Request\Url;

readonly class DefaultRequestFactory implements RequestFactory
{
    public function __construct(private string $url, private int $port)
    {
    }

    public function get(string $path, array $headers = []): HttpRequest
    {
        return new Get(
            new Url($this->url, $this->port, $path),
            new Headers(array_merge($headers, ['Accept' => 'application/json']))
        );
    }

    public function post(string $path, array $data, array $headers = []): HttpRequest
    {
        return new Post(
            new Url($this->url, $this->port, $path),
            new Headers(array_merge($headers, ['Accept' => 'application/json', 'Content-Type' => 'application/json'])),
            new JsonBody($data)
        );
    }

    public function put(string $path, array $data, array $headers = []): HttpRequest
    {
        return new Put(
            new Url($this->url, $this->port, $path),
            new Headers(array_merge($headers, ['Accept' => 'application/json', 'Content-Type' => 'application/json'])),
            new JsonBody($data)
        );
    }

    public function delete(string $path, array $headers = []): HttpRequest
    {
        return new Delete(
            new Url($this->url, $this->port, $path),
            new Headers(array_merge($headers, ['Accept' => 'application/json'])),
        );
    }
}