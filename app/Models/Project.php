<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_name',
        'project_id',
        'project_manager_id'
    ];

    public function projectManager()
    {
        return $this->belongsTo(User::class, 'project_manager_id');
    }
}