<?php
/**
 * This file is part of flysystem-plugin-aws-s3-v3 ( Etime\Flysystem\Plugin\AWS_S3 ).
 *
 * @author      Mauro Braggio (E-Time) <m.braggio@e-time.it>
 * @copyright   2018  Mauro Braggio (E-Time) <m.braggio@e-time.it>
 * @license     MIT
 */
namespace Etime\Flysystem\Plugin\AWS_S3;

use League\Flysystem\FilesystemInterface;
use League\Flysystem\PluginInterface;
    
/**
 * AWS S3 PresignedUrl plugin.
 *
 * Implements a symlink($symlink, $target) method for Filesystem instances using LocalAdapter.
 * https://docs.aws.amazon.com/aws-sdk-php/v3/guide/service/s3-presigned-url.html
 */
class PresignedUrl implements PluginInterface
{
    /**
     * FilesystemInterface instance.
     *
     * @var FilesystemInterface
     */
    protected $filesystem;

    /**
     * Sets the Filesystem instance.
     *
     * @param FilesystemInterface $filesystem
     */
    public function setFilesystem(FilesystemInterface $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * Gets the method name.
     *
     * @return string
     */
    public function getMethod()
    {
        return 'getPresignedUrl';
    }

    /**
     * Method logic.
     *
     * Get a Presigned Url for a file.
     *
     * @see http://php.net/manual/en/function.symlink.php Documentation of symlink().
     *
     * @param   string  $path        File.
     * @param   string  $expiration  Expiration time of url.
     * @return  boolean              True on success. False on failure.
     */
    public function handle($path, $expiration = "+20 minutes")
    {
        $adapter = $this->filesystem->getAdapter();        
        
        $options = [
            'Bucket' => $adapter->getBucket(),
            'Key' => $adapter->applyPathPrefix($path),
        ];
      
        /*
        if (isset($adapter->options['@http'])) {
            $options['@http'] = $adapter->options['@http'];
        }
        */
        
        $S3Client = $adapter->getClient();
        $command = $S3Client->getCommand('getObject', $options /*+ $adapter->options */ );
        try {
            $request = $S3Client->createPresignedRequest($command, $expiration);
            return (string) $request->getUri();
        } catch (S3Exception $exception) {
            return false;
        }
        
        return false;
    }
}
