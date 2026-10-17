<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

#[Fillable(['key', 'value'])]
class Setting extends Model
{
    protected $primaryKey = 'key';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    public const DEFAULTS = [
        'brand' => 'Fabara Académie',
        'whatsapp' => '224000000000',
        'city' => 'Conakry, Guinée',
        'contact_email' => 'contact@exemple.com',
        'payment_info' => "Orange Money : 224 6XX XX XX XX\nMTN MoMo : 224 6XX XX XX XX",
    ];

    public static function get(string $key): ?string
    {
        $all = Cache::rememberForever('settings', fn () => static::pluck('value', 'key')->all());

        return $all[$key] ?? self::DEFAULTS[$key] ?? null;
    }

    public static function put(array $values): void
    {
        foreach ($values as $key => $value) {
            static::updateOrCreate(['key' => $key], ['value' => $value]);
        }
        Cache::forget('settings');
    }
}
