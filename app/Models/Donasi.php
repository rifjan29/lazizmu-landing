<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donasi extends Model
{
    use HasFactory;
    protected $table = 'donasi';
    protected $fillable = [
        'cover',
        'title',
        'slug',
        'kategori_id',
        'status',
        'status_donasi',
        'user_id',
        'total_dana',
        'total_donatur',
        'content',
        'sub_content',
    ];

    function kategori() {
        return $this->belongsTo(KategoriDonasi::class,'kategori_id','id');
    }
    function user() {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
