<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialRequest extends Model
{
    protected $fillable = [
        'request_by',
        'site_id',
        'document',
        'request_date',
        'approval_date',
        'status',
        'remark',
        'do_release'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'request_by');
    }
}
