<?php

declare(strict_types=1);

namespace Tests\TestCases;

abstract class ApiLoggedInTestCase extends ApiTestCase
{
    /** @var string[] */
    protected array $headers = [];

    protected function setUp(): void
    {
        parent::setUp();
        $this->headers = [
            'Authorization' => 'Bearer '.$this->getBearerToken(),
        ];
    }

    public function getJson($uri, array $headers = [], $options = 0)
    {
        return parent::getJson($uri, array_merge($this->headers, $headers), $options);
    }

    public function postJson($uri, array $data = [], array $headers = [], $options = 0)
    {
        return parent::postJson($uri, $data, array_merge($this->headers, $headers), $options);
    }

    public function patchJson($uri, array $data = [], array $headers = [], $options = 0)
    {
        return parent::patchJson($uri, $data, array_merge($this->headers, $headers), $options);
    }

    public function putJson($uri, array $data = [], array $headers = [], $options = 0)
    {
        return parent::putJson($uri, $data, array_merge($this->headers, $headers), $options);
    }

    public function deleteJson($uri, array $data = [], array $headers = [], $options = 0)
    {
        return parent::deleteJson($uri, $data, array_merge($this->headers, $headers), $options);
    }
}
