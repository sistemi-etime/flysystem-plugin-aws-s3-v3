<?php
include __DIR__ . '/../vendor/autoload.php';

use Etime\Flysystem\Plugin\AWS_S3 as AWS_S3_Plugin;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use League\Flysystem\Filesystem;
use Aws\S3\S3Client;

$client = new S3Client([
    'credentials' => [
        'key'    => 'your-key',
        'secret' => 'your-secret'
    ],
    'region' => 'your-region',
    'version' => 'latest|version',
]);

$adapter = new AwsS3Adapter($client, 'your-bucket-name');
$filesystem = new Filesystem($adapter);

$filesystem->addPlugin(new AWS_S3_Plugin\PresignedUrl());

$success = $filesystem->getPresignedUrl('/tmp/some/target');

echo $success;

