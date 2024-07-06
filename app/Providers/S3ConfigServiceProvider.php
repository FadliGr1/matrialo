<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\AWSConfig;

class S3ConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        if (Schema::hasTable('aws_configs')) {
            $awsConfig = AWSConfig::first();

            if ($awsConfig) {
                config([
                    'filesystems.disks.s3.key' => $awsConfig->aws_access_key,
                    'filesystems.disks.s3.secret' => $awsConfig->aws_secret_key,
                    'filesystems.disks.s3.region' => $awsConfig->aws_region,
                    'filesystems.disks.s3.bucket' => $awsConfig->aws_bucket,
                    'filesystems.disks.s3.endpoint' => $awsConfig->aws_endpoint,
                    'filesystems.disks.s3.use_path_style_endpoint' => true,
                ]);
            }
        }
    }
}
