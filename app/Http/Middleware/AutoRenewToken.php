<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AutoRenewToken
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user) {
            $token = $user->currentAccessToken();

            // Renew if token expires in less than 30 days
            if ($token && $token->expires_at && $token->expires_at->diffInDays(now()) < 30) {
                // Delete old token
                $token->delete();

                // Create new token (1 year)
                $newToken = $user->createToken(
                    'auth_token',
                    ['*'],
                    now()->addYear()
                );

                // Attach new token to response
                $request->attributes->set('new_token', $newToken->plainTextToken);
            }
        }
        return $next($request);
    }
}
