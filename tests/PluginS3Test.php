<?php
use PHPUnit\Framework\TestCase;
use Etime\Flysystem\Plugin\AWS_S3 as AWS_S3_Plugin;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use League\Flysystem\Filesystem;
use Aws\S3\S3Client;

class PluginS3Test extends TestCase
{
    public function testGetPresignedUrl()
    {
        $client = new S3Client([
            'credentials' => [
                'key'    => 'your-key',
                'secret' => 'your-secret'
            ],
            'region' => 'your-region',
            'version' => 'latest',
        ]);

        $adapter = new AwsS3Adapter($client, 'your-bucket-name');
        $filesystem = new Filesystem($adapter);

        $filesystem->addPlugin(new AWS_S3_Plugin\PresignedUrl());

        $success = $filesystem->getPresignedUrl('/tmp/some/target');

        $this->assertNotFalse( $success );
    }
}
?>