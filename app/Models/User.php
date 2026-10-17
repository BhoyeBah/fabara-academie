<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;

#[Fillable(['name', 'email', 'phone', 'password', 'terms_accepted_at', 'terms_version'])]
#[Hidden(['password', 'remember_token', 'is_admin'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'terms_accepted_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function isAdmin(): bool
    {
        return (bool) $this->is_admin;
    }

    /** Formations payées par ce client (accès au lien Google Drive). */
    public function purchasedCourses(): Collection
    {
        $ids = OrderItem::query()
            ->whereNotNull('course_id')
            ->whereHas('order', fn ($q) => $q->where('user_id', $this->id)->where('status', Order::PAID))
            ->pluck('course_id');

        return Course::with('category')->whereIn('id', $ids)->orderBy('title')->get();
    }

    public function owns(Course $course): bool
    {
        return OrderItem::query()
            ->where('course_id', $course->id)
            ->whereHas('order', fn ($q) => $q->where('user_id', $this->id)->where('status', Order::PAID))
            ->exists();
    }
}
