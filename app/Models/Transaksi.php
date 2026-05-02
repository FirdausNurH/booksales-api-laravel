<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'quantity',
        'total_price',
        'status',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
    ];

    // Relasi: Transaksi dimiliki oleh satu User (Customer)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Transaksi melibatkan satu Buku
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}