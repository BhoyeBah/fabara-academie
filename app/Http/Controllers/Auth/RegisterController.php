<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:190', 'unique:users,email'],
            'phone' => ['required', 'string', 'regex:/^\+?[0-9 ]{8,20}$/'],
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
            'terms' => ['accepted'],
        ], [
            'terms.accepted' => 'Vous devez accepter les conditions d\'utilisation et la politique de confidentialité.',
            'phone.regex' => 'Entrez un numéro valide, avec l\'indicatif (ex. 224 620 00 00 00).',
        ]);

        // Un compte créé par ce formulaire est TOUJOURS un compte client (is_admin reste à false).
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => preg_replace('/[^0-9+]/', '', $data['phone']),
            'password' => $data['password'],
            'terms_accepted_at' => now(),
            'terms_version' => config('legal.version'),
        ]);

        event(new Registered($user));
        Auth::login($user);
        $request->session()->regenerate();

        if (\App\Http\Controllers\CartController::addPendingCourse()) {
            return redirect()->route('cart.index')->with('status', 'Bienvenue ! Ton compte est créé et ta formation est dans ton panier.');
        }

        return redirect()->intended(route('account.dashboard'))->with('status', 'Bienvenue ! Ton compte est créé.');
    }
}
