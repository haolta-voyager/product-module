<?php

namespace Modules\Product\Http\Middleware;

use App\Contracts\UserAuthorizationInterface;
use Closure;
use Illuminate\Http\Request;

class CheckUserRole
{
    public function __construct(
        protected UserAuthorizationInterface $userAuthorization
    ) {}

    public function handle(Request $request, Closure $next)
    {
        if (!$this->userAuthorization->canManageProducts($request->user())) {
            abort(403, 'You do not have permission to manage products');
        }

        return $next($request);
    }
}
