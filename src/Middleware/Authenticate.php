<?php

namespace Leeto\Admin\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    public function handle($request, Closure $next)
    {
        $redirectTo = config('admin.auth.redirect_to', 'admin/login');

        if (Auth::guard("admin")->guest() && !$this->except($request)) {
            return redirect()->guest($redirectTo);
        }

        return $next($request);
    }

    /**
     * Determine if the request has a URI that should pass through verification.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    protected function except($request)
    {
        return $request->is([
            'admin/login',
            'admin/logout',
        ]);
    }
}
