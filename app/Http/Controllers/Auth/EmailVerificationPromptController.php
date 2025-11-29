<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    public function __invoke(Request $request): RedirectResponse|View
    {
        if ($request->user()->hasVerifiedEmail()) {
            $destination = $request->user()->isClient()
                ? route('portal.dashboard')
                : route('admin.time-logs.index');

            return redirect()->intended($destination);
        }

        return view('auth.verify-email');
    }
}
