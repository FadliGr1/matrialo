<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AWSConfig extends Model
{
    use HasFactory;
    protected $table = 'aws_configs';

    protected $fillable = [
        'aws_access_key',
        'aws_secret_key',
        'aws_bucket',
        'aws_region',
        'aws_endpoint',
    ];
}
