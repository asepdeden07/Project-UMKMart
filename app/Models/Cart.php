<?php

namespace App\Models;

use Database\Factories\CartFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    /** @use HasFactory<CartFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
    ];

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Helper Methods
     */
    public function getTotal(): float
    {
        return (float) $this->items()->sum(\DB::raw('price * quantity'));
    }

    public function getItemCount(): int
    {
        return $this->items()->count();
    }

    public function isEmpty(): bool
    {
        return $this->items()->count() === 0;
    }

    public function clear(): void
    {
        $this->items()->delete();
    }
}
