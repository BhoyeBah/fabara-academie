<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(): View
    {
        $courses = Course::published()->with('category')->whereIn('id', session('cart', []))->get();

        return view('cart.index', ['courses' => $courses, 'total' => $courses->sum('price')]);
    }

    public function add(Course $course): RedirectResponse
    {
        abort_unless($course->is_published, 404);

        // Pas de compte = pas de formation : on garde le choix en mémoire et on envoie vers l'inscription.
        if (! auth()->check()) {
            session(['pending_course' => $course->id]);

            return redirect()->route('register')
                ->with('status', 'Crée ton compte gratuit pour obtenir « '.$course->title.' ». Elle sera ajoutée à ton panier juste après.');
        }

        if (auth()->user()->owns($course)) {
            return redirect()->route('account.dashboard')->with('status', 'Tu as déjà cette formation.');
        }

        $cart = session('cart', []);
        if (! in_array($course->id, $cart)) {
            $cart[] = $course->id;
        }
        session(['cart' => $cart]);

        return back()->with('status', '« '.$course->title.' » ajoutée à votre sélection.');
    }

    /** Après inscription ou connexion : ajoute la formation choisie avant de créer le compte. */
    public static function addPendingCourse(): bool
    {
        $id = session()->pull('pending_course');
        if (! $id || ! Course::published()->whereKey($id)->exists()) {
            return false;
        }
        $cart = session('cart', []);
        if (! in_array($id, $cart)) {
            $cart[] = $id;
        }
        session(['cart' => $cart]);

        return true;
    }

    public function remove(Course $course): RedirectResponse
    {
        session(['cart' => array_values(array_diff(session('cart', []), [$course->id]))]);

        return back();
    }
}
