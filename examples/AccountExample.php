
<?php

use Dotmailer\Request\AccountRequest;

require('vendor/autoload.php');

$config = new Dotmailer\Config('config/config.yml');

$request = new AccountRequest($config);
$response = $request->info();

echo "Account name is " . $response->getProperty('Name') . "\n";
echo "Account email is " . $response->getProperty('MainEmail') . "\n";
