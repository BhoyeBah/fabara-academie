<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

#[Fillable(['user_id', 'reference', 'total', 'status', 'payment_method', 'paid_at'])]
class Order extends Model
{
    public const PENDING = 'pending';
    public const PAID = 'paid';
    public const CANCELLED = 'cancelled';

    public const STATUS_LABELS = [
        self::PENDING => 'En attente de paiement',
        self::PAID => 'Payée',
        self::CANCELLED => 'Annulée',
    ];

    public const PAYMENT_METHODS = ['Orange Money', 'MTN MoMo', 'Wave', 'Espèces', 'Autre'];

    protected function casts(): array
    {
        return ['paid_at' => 'datetime', 'total' => 'integer'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function newReference(): string
    {
        do {
            $ref = 'CMD-'.strtoupper(Str::random(6));
        } while (static::where('reference', $ref)->exists());

        return $ref;
    }

    public function statusLabel(): string
    {
        return self::STATUS_LABELS[$this->status] ?? $this->status;
    }
}
