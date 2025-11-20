<?php

namespace Modules\User\Services;

use App\Contracts\UserAuthorizationInterface;
use Illuminate\Contracts\Auth\Authenticatable;
use Modules\User\Enums\UserRole;

class UserAuthorizationService implements UserAuthorizationInterface
{
    public function canManageProducts(?Authenticatable $user): bool
    {
        if (!$user || !isset($user->role)) {
            return false;
        }

        return $user->role->canManageProducts();
    }

    public function canReview(?Authenticatable $user): bool
    {
        if (!$user || !isset($user->role)) {
            return false;
        }

        return $user->role->canReview();
    }
}
