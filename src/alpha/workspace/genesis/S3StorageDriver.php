<?php

require_once 'FileUploadDataSourceDriver.php';
require 'vendor/autoload.php'; // Ensure AWS SDK for PHP is included via Composer

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

/**
 * S3StorageDriver provides functionality to interact with AWS S3 and S3-compatible storage services.
 *
 * This driver supports operations such as file upload, deletion, and retrieving the file location. It is designed
 * to be flexible, allowing configuration for various S3-compatible services by specifying custom endpoints and
 * credentials through a JSON configuration object. This makes it suitable for a wide range of cloud storage solutions.
 *
 * @package AxisShield
 * @author Tristan McGowan
 */
class S3StorageDriver implements FileUploadDataSourceDriver
{
    /**
     * @var S3Client The S3 client instance for interacting with the storage service.
     */
    private $s3Client;

    /**
     * @var string The name of the bucket used for storage operations.
     */
    private $bucket;

    /**
     * Initializes the S3 client with the provided JSON configuration.
     *
     * The configuration should include necessary details such as credentials, bucket name, region, and optionally
     * a custom endpoint for S3-compatible services. Throws exceptions for missing configuration or initialization errors.
     *
     * @param string $jsonConfig The JSON string containing the configuration parameters.
     * @throws InvalidArgumentException If the JSON configuration is invalid or missing required keys.
     * @throws Exception If there's an error initializing the S3 Client.
     */
    public function loadConfig(string $jsonConfig): void
    {
        $config = json_decode($jsonConfig, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException('Invalid JSON configuration provided.');
        }

        if (!isset($config['bucket'])) {
            throw new InvalidArgumentException('Bucket name is required in the configuration.');
        }

        $this->bucket = $config['bucket'];
        unset($config['bucket']); // Prepare the rest of the config for S3Client

        try {
            $this->s3Client = new S3Client($config);
        } catch (AwsException $e) {
            throw new Exception('Error initializing S3 Client: ' . $e->getMessage());
        }
    }

    /**
     * Uploads a file to the specified bucket using the S3 client.
     *
     * @param string $filePath The path to the local file to be uploaded.
     * @param string $destination The destination path in the bucket.
     * @return bool True on success, false on failure.
     */
    public function saveFile(string $filePath, string $destination): bool
    {
        try {
            $result = $this->s3Client->putObject([
                'Bucket' => $this->bucket,
                'Key'    => $destination,
                'Body'   => fopen($filePath, 'rb'),
            ]);
            return !!$result;
        } catch (AwsException $e) {
            // Implement logging or error handling as appropriate
            return false;
        }
    }

    /**
     * Deletes a file from the specified bucket.
     *
     * @param string $filePath The path to the file in the bucket to be deleted.
     * @return bool True on success, false on failure.
     */
    public function deleteFile(string $filePath): bool
    {
        try {
            $result = $this->s3Client->deleteObject([
                'Bucket' => $this->bucket,
                'Key'    => $filePath,
            ]);
            return !!$result;
        } catch (AwsException $e) {
            // Implement logging or error handling as appropriate
            return false;
        }
    }

    /**
     * Retrieves the publicly accessible URL of a file in the specified bucket.
     *
     * @param string $filePath The path to the file in the bucket.
     * @return string The URL to access the file.
     */
    public function getFileLocation(string $filePath): string
    {
        return $this->s3Client->getObjectUrl($this->bucket, $filePath);
    }
}
