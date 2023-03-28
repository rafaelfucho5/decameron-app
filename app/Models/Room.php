<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Room extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'quantity',
        'type',
        'accommodation',
        'hotel_id',
    ];

    /**
     * Relationship Hotel Function.
     *
     * @return BelongsTo
     */
    public function hotel(): BelongsTo
    {
        return $this->BelongsTo(Hotel::class);
    }
}
