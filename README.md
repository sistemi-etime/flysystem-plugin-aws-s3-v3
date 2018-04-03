# Flysystem AWS S3 Plugin

[![Author](http://img.shields.io/badge/author-mauro.braggio.svg?style=flat-square)](https://www.e-time.it)
[![Author](https://img.shields.io/badge/author-www.e--time.it-blue.svg?style=flat-square)](https://www.e-time.it)

[![Build Status](https://img.shields.io/travis/sistemi-etime/flysystem-plugin-aws-s3-v3/master.svg?style=flat-square)](https://travis-ci.org/sistemi-etime/flysystem-plugin-aws-s3-v3)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Packagist Version](https://img.shields.io/packagist/v/sistemi-etime/flysystem-plugin-aws-s3-v3.svg?style=flat-square)](https://packagist.org/packages/sistemi-etime/flysystem-plugin-aws-s3-v3)
[![Total Downloads](https://img.shields.io/packagist/dt/sistemi-etime/flysystem-plugin-aws-s3-v3.svg?style=flat-square)](https://packagist.org/packages/sistemi-etime/flysystem-plugin-aws-s3-v3)

## Requirements

+ [Flysystem](http://flysystem.thephpleague.com/) >= 1.0.0

## Installation

Using composer:

```
composer require sistemi-etime/flysystem-plugin-aws-s3-v3
```

Or add it manually:

```json
{
    "require": {
        "sistemi-etime/flysystem-plugin-aws-s3-v3": "1.*"
    }
}
```

## Usage

This plugin requires a `Filesystem` instance using the [AwsS3Adapter adapter]).

```php
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
```
