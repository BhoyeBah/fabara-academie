<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        return view('account.dashboard', [
            'courses' => $user->purchasedCourses(),
            'orders' => $user->orders()->with('items')->latest()->get(),
        ]);
    }

    /** Ouvre le dossier Google Drive : seulement pour un client qui a payé cette formation. */
    public function access(Request $request, Course $course): RedirectResponse
    {
        abort_unless($request->user()->owns($course), 404);

        if (! $course->drive_url) {
            return back()->with('status', 'Le lien de cette formation est en cours de préparation. Nous vous prévenons sur WhatsApp dès qu\'il est prêt.');
        }

        return redirect()->away($course->drive_url);
    }
}
