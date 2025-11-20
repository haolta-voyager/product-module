<?php

namespace App\Contracts;

use Illuminate\Contracts\Auth\Authenticatable;

interface UserAuthorizationInterface
{
    /**
     * Check if user can manage products
     */
    public function canManageProducts(?Authenticatable $user): bool;

    /**
     * Check if user can write reviews
     */
    public function canReview(?Authenticatable $user): bool;
}
