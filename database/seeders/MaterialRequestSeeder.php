<?php

namespace Database\Seeders;

use App\Models\MaterialRequest;
use App\Models\User;
use Illuminate\Database\Seeder;

class MaterialRequestSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first(); // Get existing user

        MaterialRequest::create([
            'request_by' => $user->id,
            'site_id' => 'SITE001',
            'document' => 'document1.xlsx',
            'request_date' => now(),
            'status' => 'need_revision',
            'remark' => 'Initial request for SITE001'
        ]);

        MaterialRequest::create([
            'request_by' => $user->id,
            'site_id' => 'SITE002',
            'document' => 'document2.xlsx',
            'request_date' => now(),
            'status' => 'approved',
            'approval_date' => now(),
            'do_release' => 'release1.xlsx',
            'remark' => 'Approved request for SITE002'
        ]);
    }
}