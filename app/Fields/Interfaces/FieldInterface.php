<?php

declare(strict_types=1);

namespace App\Fields\Interfaces;

use App\Fields\Enums\TypeFieldEnum;
use App\Parameters\Domain\Models\Parameter;

interface FieldInterface
{
    public function getId(): string;

    public function getValue(): string;

    public function getParameter(): ?Parameter;

    public function getType(): TypeFieldEnum;
}
