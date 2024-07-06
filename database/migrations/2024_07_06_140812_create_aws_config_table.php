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
        Schema::create('aws_config', function (Blueprint $table) {
            $table->id();
            $table->string('aws_access_key');
            $table->string('aws_secret_key');
            $table->string('aws_bucket');
            $table->string('aws_region');
            $table->string('aws_endpoint');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aws_config');
    }
};
