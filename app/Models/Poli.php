<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poli extends Model
{
    protected $fillable = [
        'nama',
        'deskripsi',
    ];

    public function user()
    {
        return $this->hasMany(User::class, 'id_poli');
    }
}
