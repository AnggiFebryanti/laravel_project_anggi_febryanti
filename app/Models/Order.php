<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tanggal',
        'total',
        'bukti_pembayaran',
        'status_pembayaran',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'total' => 'decimal:2',
    ];

    /**
     * Get the user that owns the order.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the order products for the order.
     */
    public function orderProducts(): HasMany
    {
        return $this->hasMany(OrderProduct::class);
    }

    /**
     * Calculate the total from order products.
     */
    public function calculateTotal(): float
    {
        return $this->orderProducts->sum(function ($item) {
            return $item->jumlah * $item->harga_satuan;
        });
    }

    /**
     * Get the status badge color.
     */
    public function getStatusBadgeAttribute(): string
    {
        switch ($this->status_pembayaran) {
            case 'pending':
                return 'badge bg-label-warning';
            case 'sukses':
                return 'badge bg-label-success';
            case 'gagal':
                return 'badge bg-label-danger';
            default:
                return 'badge bg-label-secondary';
        }
    }
}
