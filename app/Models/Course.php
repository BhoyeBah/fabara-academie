<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['category_id', 'code', 'slug', 'title', 'description', 'level', 'hours', 'lessons', 'price', 'program', 'drive_url', 'is_published'])]
#[Hidden(['drive_url'])]
class Course extends Model
{
    public const LEVELS = ['Débutant', 'Intermédiaire', 'Avancé', 'Tous niveaux'];

    protected function casts(): array
    {
        return [
            'program' => 'array',
            'drive_url' => 'encrypted', // le lien est chiffré en base de données
            'is_published' => 'boolean',
            'price' => 'integer',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopePublished(Builder $query): void
    {
        $query->where('is_published', true);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
