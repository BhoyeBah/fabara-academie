<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TermsController extends Controller
{
    public function show(): View
    {
        return view('account.terms');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(['terms' => ['accepted']], ['terms.accepted' => 'Cochez la case pour continuer.']);
        $request->user()->forceFill(['terms_accepted_at' => now(), 'terms_version' => config('legal.version')])->save();

        return redirect()->route('account.dashboard');
    }
}
