# PHP Dotmailer v2 API
A PHP implementation of the [v2 Dotmailer API](http://api.dotmailer.com/).

# Installation

* Clone the repository
* Make sure you have [composer](http://getcomposer.org/) set up and working
* Install dependencies by running `composer install`
* Copy the sample config file (`config/config.yml.sample`) to `config/config.yml`
* Update config/config.yml with your API credentials from Dotmailer

# Notes

* I'm tracking completeness of the API via the `COVERAGE.md` file
    * Items with an [x] are probably implemented - but the implementation isn't guaranteed complete. This is particularly the case for optional parameters
* Docblocks are missing in many places - patches welcome
* PHPUnit is set up, and some test cases are present. More would be welcome.
* Requires PHP 5.4 or above.

# Examples

See the examples/ folder for examples of how to use the API wrapper. This is designed to get you going, and is not a complete reference.
