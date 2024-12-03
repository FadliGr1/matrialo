<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('material_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_by')->constrained('users');
            $table->string('site_id');
            $table->string('document');
            $table->date('request_date');
            $table->date('approval_date')->nullable();
            $table->enum('status', ['need_revision', 'rejected', 'approved'])->default('need_revision');
            $table->text('remark')->nullable();
            $table->string('do_release')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_requests');
    }
};
