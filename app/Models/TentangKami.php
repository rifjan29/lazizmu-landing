<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TentangKami extends Model
{
    use HasFactory;
    protected $table = 'tentang_kami';
    protected $fillable = [
        'latar_belakang',
        'visi',
        'misi',
        'prinsip',
        'gambar',
        'user_id',
        'no_wa',
        'tujuan',
    ];

    public function user() {
        return $this->belongsTo(User::class,'user_id');
    }
}
