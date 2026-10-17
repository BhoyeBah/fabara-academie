<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function edit(): View
    {
        return view('admin.settings');
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'brand' => ['required', 'string', 'max:80'],
            'whatsapp' => ['required', 'regex:/^\+?[0-9 ]{8,20}$/'],
            'city' => ['nullable', 'string', 'max:80'],
            'contact_email' => ['required', 'email'],
            'payment_info' => ['nullable', 'string', 'max:1000'],
        ]);
        $data['whatsapp'] = preg_replace('/\D/', '', $data['whatsapp']);
        Setting::put($data);

        return back()->with('status', 'Réglages enregistrés.');
    }
}
