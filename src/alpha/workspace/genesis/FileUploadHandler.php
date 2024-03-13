Author: Tristan McGowan (tristan@ipspy.net)
Date: Wed, March 13, 2:00 AM CDT

FileUploadHandler.php Overview
This PHP script serves as an endpoint for receiving files uploaded from the PowerShell script. It validates the uploaded file, the 'bucket' directory where the file should be stored, and a 32-byte security token for authentication.

Iteration Notes:
- The initial version introduced basic file handling and bucket management.
- Security features were enhanced by requiring a 'secToken' parameter for authentication.
- Final adjustments ensured robust error handling and security measures.
