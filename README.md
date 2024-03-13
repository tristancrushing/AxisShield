# AxisShield

AxisShield is an open-source project designed to facilitate the easy backup of continuous recording camera feeds to cloud storage solutions such as Amazon S3 and Digital Ocean's Spaces Object Storage. Utilizing a combination of Windows Server services, PowerShell scripts, and PHP endpoints, AxisShield offers a robust and scalable solution for managing large volumes of video data. The project leverages AWS Lambda and Digital Ocean Functions to handle the remote REST upload endpoints, ensuring a secure and efficient backup process.

## Founding Author
Tristan McGowan (tristan@ipspy.net)

### Portfolio
[LinkedIn](https://www.linkedin.com/in/tristan-mcgowan-bestdev/ "LinkedIn")

[IP Spy](https://ipspy.net "ipspy.net")

### Recent Projects

[Midwest Public Safety Consulting Group (Branding & Web Tech)](https://mpscg.com "Midwest Public Safety Consulting Group")

[Waypoint Logistics (Custom Proprietary Dispatching/Routing/Tracking Software)](https://waypointlogistics.com "WayPoint Logistics")


## Features

- Automated backup of camera feeds to S3 or Digital Ocean Spaces
- Secure transmission of video data using AWS Lambda or Digital Ocean Functions
- Easy setup and configuration through PowerShell scripts and PHP endpoints
- Customizable storage options to meet various data retention policies

## Installation

### Prerequisites

- A Windows Server environment for running services and scripts
- AWS or Digital Ocean account for cloud storage and function execution
- PHP 7.4 or newer for the endpoint server

### Setup Guide

1. **Windows Server Services and PowerShell Scripts**: Clone the repository to your server and follow the setup instructions provided in the `/services` and `/scripts` directories to install the necessary services and scripts.

2. **PHP Endpoints**: Deploy the PHP scripts found in the `/endpoints` directory to your web server. Configure the web server to serve the PHP scripts properly.

3. **Cloud Functions**: Follow the instructions in the `/cloud-functions/aws-lambda` or `/cloud-functions/digital-ocean-functions` directories to deploy the functions to your chosen cloud platform.

## Usage

After completing the installation and setup process, AxisShield will automatically monitor specified camera feeds for new recordings and back them up to the configured cloud storage solution. Detailed usage instructions and configuration options can be found in the respective directories for each component of the project.

## Contributing

Contributions to AxisShield are welcome and appreciated. If you would like to contribute, please fork the repository, create a feature branch, and submit a pull request with your changes. For more detailed information, please refer to the `CONTRIBUTING.md` file.

## License

AxisShield is released under the MIT License. See the `LICENSE.md` file for more information.

## Acknowledgments

- Thanks to all the contributors who have invested time and effort into making AxisShield a valuable tool for the community.
- Special thanks to AWS and Digital Ocean for providing the cloud infrastructure that powers the backup solutions.

