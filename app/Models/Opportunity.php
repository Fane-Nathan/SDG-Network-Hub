<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Opportunity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'summary',
        'opportunity_type',
        'mode',
        'sdg_focus',
        'location_country',
        'location_city',
        'start_date',
        'end_date',
        'deadline',
        'capacity',
        'status',
        'contact_email',
        'contact_phone',
        'description',
        'published_at',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'deadline' => 'date',
        'published_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $opportunity) {
            if (! $opportunity->slug) {
                $opportunity->slug = Str::slug(substr($opportunity->title, 0, 60)) . '-' . Str::random(5);
            }
        });
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'open');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when(($filters['search'] ?? null), function ($query, $search) {
            $query->where(function ($sub) use ($search) {
                $sub->where('title', 'like', "%{$search}%")
                    ->orWhere('summary', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        });

        $query->when(($filters['location'] ?? null), function ($query, $location) {
            $query->where(function ($sub) use ($location) {
                $sub->where('location_country', 'like', "%{$location}%")
                    ->orWhere('location_city', 'like', "%{$location}%");
            });
        });

        $query->when(($filters['sdg'] ?? null), function ($query, $sdg) {
            $query->where('sdg_focus', 'like', "%{$sdg}%");
        });

        $query->when(($filters['type'] ?? null), function ($query, $type) {
            $query->where('opportunity_type', $type);
        });

        $query->when(($filters['mode'] ?? null), function ($query, $mode) {
            $query->where('mode', $mode);
        });
    }

    public function isOpen(): bool
    {
        return $this->status === 'open';
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}