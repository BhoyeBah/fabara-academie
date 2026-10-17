<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PageController extends Controller
{
    public function privacy(): View
    {
        return view('pages.privacy');
    }

    public function terms(): View
    {
        return view('pages.terms');
    }

    /** Page publique exigée par Google Play : comment supprimer son compte et ses données. */
    public function deletion(): View
    {
        return view('pages.deletion');
    }
}
