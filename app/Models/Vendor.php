<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_name',
        'alamat',
        'alamat_gudang',
        'penanggung_jawab',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'penanggung_jawab');
    }

    public function penanggungJawab()
    {
        return $this->belongsTo(User::class, 'penanggung_jawab');
    }
}
