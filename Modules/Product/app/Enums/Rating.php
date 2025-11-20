<?php

namespace Modules\Product\Enums;

enum Rating: int
{
    case ONE = 1;
    case TWO = 2;
    case THREE = 3;
    case FOUR = 4;
    case FIVE = 5;

    public function label(): string
    {
        return match ($this) {
            self::ONE => '1 Star',
            self::TWO => '2 Stars',
            self::THREE => '3 Stars',
            self::FOUR => '4 Stars',
            self::FIVE => '5 Stars',
        };
    }

    public function stars(): string
    {
        return str_repeat('⭐', $this->value);
    }
}
