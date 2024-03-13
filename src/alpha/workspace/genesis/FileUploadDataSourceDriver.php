<?php

/**
 * Defines the interface for file upload data source drivers.
 *
 * This interface establishes a contract for implementing classes to support file
 * operations (e.g., save, delete) across different storage backends like S3-compatible
 * cloud services, and local or network-attached storage systems (HDD, SSD, NVMe, NAS).
 * It also includes a method for loading configuration from a JSON string, enabling
 * dynamic and flexible driver configuration.
 *
 * Implementing this interface allows the application to switch seamlessly between
 * different storage options without modifying the code that uses these drivers, thereby
 * adhering to the Open/Closed Principle of SOLID design principles.
 *
 * @package AxisShield
 * @author Tristan McGowan
 */
interface FileUploadDataSourceDriver
{
    /**
     * Loads configuration for the driver from a JSON string.
     *
     * This method allows for dynamic configuration of the driver, providing the flexibility
     * to adjust settings based on the environment or specific requirements of the storage backend.
     *
     * @param string $jsonConfig A JSON string containing configuration parameters for the driver.
     * @throws InvalidArgumentException If the provided JSON string is invalid or cannot be parsed.
     * @return void
     */
    public function loadConfig(string $jsonConfig): void;

    /**
     * Saves a file to the designated storage location.
     *
     * Implementing this method should handle all logic required to securely and efficiently
     * upload a file to the storage backend specified by the driver configuration.
     *
     * @param string $filePath The path to the file that needs to be uploaded.
     * @param string $destination The destination path where the file should be stored.
     * @return bool True if the file was successfully saved; false otherwise.
     */
    public function saveFile(string $filePath, string $destination): bool;

    /**
     * Deletes a file from the storage location.
     *
     * This method should remove the specified file from the storage backend, ensuring that
     * the operation is performed securely and efficiently.
     *
     * @param string $filePath The path to the file that needs to be deleted.
     * @return bool True if the file was successfully deleted; false otherwise.
     */
    public function deleteFile(string $filePath): bool;

    /**
     * Retrieves the URL or path to a stored file.
     *
     * Depending on the storage backend, this method returns a URL or a file path that can
     * be used to access the stored file. For cloud storage, it typically returns a URL,
     * while for local storage, it might return a filesystem path.
     *
     * @param string $filePath The path of the file for which to retrieve the location.
     * @return string The URL or path that can be used to access the file.
     */
    public function getFileLocation(string $filePath): string;
}
