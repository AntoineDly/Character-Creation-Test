<?php

declare(strict_types=1);

namespace App\Fields\Models;

use App\Parameters\Models\Parameter;

interface FieldInterface
{
    public function getId(): string;

    public function getValue(): string;

    public function getParameter(): ?Parameter;
}
