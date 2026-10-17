<?php

use App\Models\Setting;

if (! function_exists('gnf')) {
    /** Formate un montant en francs guinéens : 75 000 GNF */
    function gnf(int|float|null $amount): string
    {
        return number_format((float) $amount, 0, ',', ' ').' GNF';
    }
}

if (! function_exists('setting')) {
    function setting(string $key): ?string
    {
        return Setting::get($key);
    }
}

if (! function_exists('wa_link')) {
    /** Lien WhatsApp avec message pré-rempli. */
    function wa_link(?string $number, string $text): string
    {
        return 'https://wa.me/'.preg_replace('/\D/', '', (string) $number).'?text='.rawurlencode($text);
    }
}
