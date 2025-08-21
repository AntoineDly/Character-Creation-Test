<?php

declare(strict_types=1);

namespace App\Shared\Fields\Interfaces;

use App\Parameters\Domain\Models\Parameter;
use App\Shared\Fields\Enums\TypeFieldEnum;

interface FieldInterface
{
    public function getId(): string;

    public function getValue(): string;

    public function getParameter(): ?Parameter;

    public function getType(): TypeFieldEnum;
}
