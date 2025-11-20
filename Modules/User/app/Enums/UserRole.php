<?php

namespace Modules\User\Enums;

enum UserRole: string
{
    case USER = 'user';
    case CUSTOMER = 'customer';

    public function label(): string
    {
        return match ($this) {
            self::USER => 'User',
            self::CUSTOMER => 'Customer',
        };
    }

    public function canManageProducts(): bool
    {
        return $this === self::USER;
    }

    public function canReview(): bool
    {
        return $this === self::CUSTOMER;
    }
}
