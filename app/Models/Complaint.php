<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Complaint extends Model
{
    use HasUuids;

    protected $fillable = [
        'tracking_code',
        'reporter_name',
        'reporter_contact',
        'is_disability_friendly',
        'title',
        'description',
        'category_id',
        'agency_id',
        'status',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'is_disability_friendly' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(ComplaintAttachment::class);
    }

    public function responses(): HasMany
    {
        return $this->hasMany(ComplaintResponse::class)->latest();
    }
}
