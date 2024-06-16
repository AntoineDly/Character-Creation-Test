<?php

declare(strict_types=1);

namespace Tests\Feature;

test('return a response OK', function () {
    $response = $this->get('/');

    expect($response->getStatusCode())->toBe(200);
});
