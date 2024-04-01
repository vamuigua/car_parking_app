<?php

namespace App\Http\Controllers\Api\V1\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

class LogoutController extends Controller
{
    public function __invoke(Request $request)
    {
        if (EnsureFrontendRequestsAreStateful::fromFrontend($request)) {
            Auth::guard('web')->logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();
        } else {
            $request->user()->currentAccessToken()->delete();
        }

        return response()->noContent();
    }
}
