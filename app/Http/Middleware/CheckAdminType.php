<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminType
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->type == 'admin') {
            return $next($request);
        }

        // If the user is not an admin, return a 403 Forbidden response
        return abort(Response::HTTP_FORBIDDEN,'User does not have any of the necessary access rights.');
    }
}
