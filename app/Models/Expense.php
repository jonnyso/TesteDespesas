<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = ['description', 'date', 'owner_id', 'value'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'datetime',
    ];

    protected function asCurrency(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => 'R$' . number_format($this->value, 2, ',', '.')
        );
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function scopeByOwnerId($query, $id)
    {
        $query->where('owner_id', $id);
    }
}
