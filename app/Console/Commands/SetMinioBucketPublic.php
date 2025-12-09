<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Aws\S3\S3Client;

class SetMinioBucketPublic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'minio:set-bucket-public {bucket=emart}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set MinIO bucket policy to public access';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $bucket = $this->argument('bucket');

        try {
            $config = config('filesystems.disks.minio');

            $client = new S3Client([
                'version' => 'latest',
                'region' => $config['region'],
                'endpoint' => $config['endpoint'],
                'use_path_style_endpoint' => true,
                'credentials' => [
                    'key' => $config['key'],
                    'secret' => $config['secret'],
                ],
            ]);

            $policy = [
                "Version" => "2012-10-17",
                "Statement" => [
                    [
                        "Effect" => "Allow",
                        "Principal" => ["AWS" => ["*"]],
                        "Action" => [
                            "s3:GetBucketLocation",
                            "s3:ListBucket"
                        ],
                        "Resource" => ["arn:aws:s3:::{$bucket}"]
                    ],
                    [
                        "Effect" => "Allow",
                        "Principal" => ["AWS" => ["*"]],
                        "Action" => ["s3:GetObject"],
                        "Resource" => ["arn:aws:s3:::{$bucket}/*"]
                    ]
                ]
            ];

            $client->putBucketPolicy([
                'Bucket' => $bucket,
                'Policy' => json_encode($policy)
            ]);

            $this->info("Successfully set bucket '{$bucket}' to public access!");
            $this->info("You can now access files at: " . $config['endpoint'] . "/{$bucket}/[file-path]");

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error("Failed to set bucket policy: " . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
