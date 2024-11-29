<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Warehouse extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'pole_capacity',
        'cable_capacity',
        'acc_capacity',
        'used_pole_capacity',
        'used_cable_capacity',
        'used_acc_capacity'
    ];
}
