<?php
/** 
* Check for 'akid' in environment variables and assign it to $akid. 
* If 'akid' is not set, echo an error message and terminate the script.
*/ 
$akid = $_ENV['akid'] ?? (function() { echo '`akid` is a required param for this method.'; die(); })();
/** 
* Check for 'sak' in environment variables and assign it to $sak. 
* If 'sak' is not set, echo an error message and terminate the script.
*/ 
$sak = $_ENV['sak'] ?? (function() { echo '`sak` is a required param for this method.'; die(); })();

define("EXPECTED_SEC_TOKEN", $_ENV['expectedSecToken']);
/**
 * Manages the secure backup of continuous recording camera feeds to cloud storage via AxisShield.
 *
 * AxisShield orchestrates the secure and efficient backup of video surveillance data to designated cloud storage "buckets," leveraging authentication through a security token passed via a GET parameter. This mechanism ensures that backup operations are performed by authenticated entities only, reinforcing the integrity and confidentiality of the surveillance data backup process.
 *
 * @package AxisShield
 * @author Tristan McGowan
 * @date Tue, March 12th, 2024
 */
class FileUploadHandler
{
    /**
     * The path to the directory where uploaded files will be stored.
     * 
     * @var string
     */
    private $uploadPath = __DIR__ . '/tmp/';

    /**
     * The expected security token for authenticating requests.
     * 
     * @var string
     */
    private $expectedSecToken = EXPECTED_SEC_TOKEN;

    /**
     * Constructor that initiates the file upload handling process.
     */
    public function __construct()
    {
        // $this->handleFileUpload();
    }

    /**
     * Handles the file upload process, including security token and bucket validation.
     * 
     * Validates the presence of required parameters (file, bucket, secToken), sanitizes input,
     * validates the security token, and, if all checks pass, saves the file to the specified bucket.
     */
    public function handleFileUpload()
    {

        if (isset($_FILES['file']) && isset($_GET['bucket']) && isset($_GET['secToken'])) {
            $bucket = $_GET['bucket'];
            $secToken = $_GET['secToken'];
            $file = $_FILES['file'];

            // Sanitize input
            $bucket = $this->sanitizeBucketName($bucket);
            
            // Validate the file, bucket, and security token
            if ($this->validateFile($file) && $this->validateBucket($bucket) && $this->validateSecToken($secToken)) {
                $this->saveFile($file, $bucket);
            } else {
                $response = ['status' => 'error', 'message' => 'Invalid file, bucket, or security token.'];
                return ["response" => $response];
            }
        } else {
            $response = ['status' => 'error', 'message' => 'Invalid Request.'];
            return ["response" => $response];
        }
    }

    /**
     * Sanitizes the bucket name to remove potentially harmful characters.
     * 
     * @param string $bucket The bucket name to sanitize.
     * @return string The sanitized bucket name.
     */
    private function sanitizeBucketName($bucket)
    {
        return preg_replace('/[^a-zA-Z0-9_\-]/', '', $bucket);
    }

    /**
     * Validates the uploaded file for errors.
     * 
     * @param array $file The uploaded file from the $_FILES array.
     * @return bool True if the file is valid, otherwise false.
     */
    private function validateFile($file)
    {
        return $file['error'] === UPLOAD_ERR_OK;
    }

    /**
     * Validates the bucket name ensuring it's not empty after sanitization.
     * 
     * @param string $bucket The bucket name to validate.
     * @return bool True if the bucket name is valid, otherwise false.
     */
    private function validateBucket($bucket)
    {
        return !empty($bucket);
    }

    /**
     * Validates the provided security token against the expected one.
     * 
     * @param string $secToken The security token to validate.
     * @return bool True if the token is valid, otherwise false.
     */
    private function validateSecToken($secToken)
    {
        return hash_equals($this->expectedSecToken, $secToken);
    }

    /**
     * Saves the uploaded file to the specified bucket if all validations pass.
     * 
     * @param array $file The file to be uploaded.
     * @param string $bucket The bucket where the file will be saved.
     */
    private function saveFile($file, $bucket)
    {
        $targetPath = $this->uploadPath . $bucket . '/';
        exec("/usr/local/bin/s3cmd --access_key={$akid} --secret_key={$sak} put {$targetPath}/{$file} s3://{$targetPath}");
    }
}

function main(array $args) : array
{
    // Instantiating the FileUploadHandler class to initiate the file upload process.
    $FileUploadHandler = new FileUploadHandler();

    $response = $FileUploadHandler->handleFileUpload();
    return ['response' => $response];
}


?>
