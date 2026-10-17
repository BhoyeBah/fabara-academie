<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

/** L'admin modifie ses propres identifiants de connexion (e-mail et mot de passe). */
class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('admin.profile', ['user' => $request->user()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'lowercase', 'max:190', Rule::unique('users')->ignore($user->id)],
            'current_password' => ['required', 'current_password'],
        ], ['current_password.current_password' => 'Mot de passe actuel incorrect.']);

        $user->update(['name' => $data['name'], 'email' => $data['email']]);

        return back()->with('status', 'Identifiants enregistrés. Utilisez désormais '.$user->email.' pour vous connecter.');
    }

    public function password(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password_pw' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(12)->letters()->numbers()],
        ], ['current_password_pw.current_password' => 'Mot de passe actuel incorrect.']);

        $user = $request->user();
        $user->update(['password' => $request->input('password')]);
        $request->session()->regenerate();

        // Par sécurité, déconnecte l'admin de tous ses autres appareils.
        DB::table('sessions')->where('user_id', $user->id)->where('id', '!=', $request->session()->getId())->delete();
        $user->forceFill(['remember_token' => null])->save();

        return back()->with('status', 'Mot de passe modifié. Vos autres appareils ont été déconnectés.');
    }
}
