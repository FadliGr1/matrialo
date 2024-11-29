<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable = [
        'vendor_name',
        'address',
        'warehouse_address',
        'person_responsible',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'person_responsible');
    }
}
