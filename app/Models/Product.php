<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'kategori_id',
        'harga',
        'stok',
        'deskripsi',
        'foto',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'kategori_id');
    }
}
