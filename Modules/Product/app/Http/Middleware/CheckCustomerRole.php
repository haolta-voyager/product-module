<?php

namespace Modules\Product\Http\Middleware;

use App\Contracts\UserAuthorizationInterface;
use Closure;
use Illuminate\Http\Request;

class CheckCustomerRole
{
    public function __construct(
        protected UserAuthorizationInterface $userAuthorization
    ) {}

    public function handle(Request $request, Closure $next)
    {
        if (!$this->userAuthorization->canReview($request->user())) {
            abort(403, 'Only customers can write reviews');
        }

        return $next($request);
    }
}
