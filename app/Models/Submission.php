<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Submission extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'title',
        'info',
        'symptoms',
        'status',
    ];

    protected $attributes = [
        'status' => Status::PENDING,
    ];

    public function scopeFilter($query, array $filters): void
    {
        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }
    }

    /**
      * @return BelongsTo<Role>
      */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    /**
      * @return BelongsTo<Role>
      */
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    /**
      * @return HasOne<Prescription>
      */
    public function prescription(): HasOne
    {
        return $this->hasOne(Prescription::class);
    }
}
