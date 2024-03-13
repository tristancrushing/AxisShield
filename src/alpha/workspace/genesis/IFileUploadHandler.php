<?php

interface IFileUploadHandler
{
    /**
     * Initiates the file upload handling process.
     */
    public function __construct();

    /**
     * Handles the file upload process, including security token and bucket validation.
     * 
     * @return array Response array with the status and message.
     */
    public function handleFileUpload(): array;

    /**
     * Sanitizes the bucket name to remove potentially harmful characters.
     * 
     * @param string $bucket The bucket name to sanitize.
     * @return string The sanitized bucket name.
     */
    public function sanitizeBucketName(string $bucket): string;

    /**
     * Validates the uploaded file for errors.
     * 
     * @param array $file The uploaded file from the $_FILES array.
     * @return bool True if the file is valid, otherwise false.
     */
    public function validateFile(array $file): bool;

    /**
     * Validates the bucket name ensuring it's not empty after sanitization.
     * 
     * @param string $bucket The bucket name to validate.
     * @return bool True if the bucket name is valid, otherwise false.
     */
    public function validateBucket(string $bucket): bool;

    /**
     * Validates the provided security token against the expected one.
     * 
     * @param string $secToken The security token to validate.
     * @return bool True if the token is valid, otherwise false.
     */
    public function validateSecToken(string $secToken): bool;

    /**
     * Saves the uploaded file to the specified bucket if all validations pass.
     * 
     * @param array $file The file to be uploaded.
     * @param string $bucket The bucket where the file will be saved.
     */
    public function saveFile(array $file, string $bucket): void;
}
