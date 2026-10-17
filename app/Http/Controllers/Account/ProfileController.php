<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('account.profile', ['user' => $request->user()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'lowercase', 'max:190', Rule::unique('users')->ignore($user->id)],
            'phone' => ['required', 'string', 'regex:/^\+?[0-9 ]{8,20}$/'],
        ]);
        $data['phone'] = preg_replace('/[^0-9+]/', '', $data['phone']);
        $user->update($data);

        return back()->with('status', 'Vos informations sont enregistrées.');
    }

    public function password(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
        ]);
        $request->user()->update(['password' => $data['password']]);

        return back()->with('status', 'Mot de passe modifié.');
    }

    /** Droit d'accès / portabilité : le client télécharge toutes ses données. */
    public function export(Request $request): Response
    {
        $user = $request->user()->load('orders.items');
        $data = [
            'exporte_le' => now()->toIso8601String(),
            'compte' => [
                'nom' => $user->name,
                'email' => $user->email,
                'telephone' => $user->phone,
                'cree_le' => $user->created_at?->toIso8601String(),
                'conditions_acceptees_le' => $user->terms_accepted_at?->toIso8601String(),
                'version_conditions' => $user->terms_version,
            ],
            'commandes' => $user->orders->map(fn ($o) => [
                'reference' => $o->reference,
                'date' => $o->created_at->toIso8601String(),
                'statut' => $o->statusLabel(),
                'total_gnf' => $o->total,
                'moyen_de_paiement' => $o->payment_method,
                'formations' => $o->items->map(fn ($i) => ['code' => $i->course_code, 'titre' => $i->course_title, 'prix_gnf' => $i->price]),
            ]),
        ];

        return response()->streamDownload(
            fn () => print (json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)),
            'mes-donnees-'.now()->format('Y-m-d').'.json',
            ['Content-Type' => 'application/json; charset=utf-8']
        );
    }

    /** Droit à l'effacement : supprime le compte et ses données personnelles. */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate(['password_delete' => ['required', 'current_password']], [
            'password_delete.current_password' => 'Mot de passe incorrect.',
        ]);
        $user = $request->user();
        abort_if($user->isAdmin(), 403, 'Le compte administrateur ne peut pas être supprimé ici.');

        Auth::logout();
        DB::transaction(function () use ($user) {
            DB::table('sessions')->where('user_id', $user->id)->delete();
            DB::table('password_reset_tokens')->where('email', $user->email)->delete();
            // Les commandes restent pour la comptabilité, détachées de toute personne (user_id = null).
            $user->delete();
        });
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('catalog.index')->with('status', 'Votre compte et vos données personnelles ont été supprimés.');
    }
}
