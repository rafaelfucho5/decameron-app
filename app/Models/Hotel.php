<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hotel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'city',
        'room_number',
        'nit',
        'direction',
    ];

    /**
     * Relationship Room Function.
     *
     * @return HasMany
     */
    public function rooms(): HasMany
    {
        return $this->HasMany(Room::class);
    }
}
