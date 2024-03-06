<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Informasi extends Model
{
    use HasFactory;
    protected $table = 'informasi';
    protected $fillable = [
        'cover',
        'title',
        'kategori_id',
        'status_informasi',
        'status',
        'user_id',
        'content',
        'slug',
    ];

    function kategori() {
        return $this->belongsTo(Kategori::class,'kategori_id','id');
    }
    function user() {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
