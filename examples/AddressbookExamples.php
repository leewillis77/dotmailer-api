<?php

use Dotmailer\Entity\Addressbook;
use Dotmailer\Request\AddressbookRequest;

require('vendor/autoload.php');

$config = new Dotmailer\Config('config/config.yml');

$request = new AddressbookRequest($config);

// Grab all addressbooks
$all_books = $request->getAll();

// Grab all public addressbooks
$public_books = $request->getAllPublic();

// Grab all private addressbooks
$private_books = $request->getAllPrivate();

// Collection objects can be iterated over...
foreach ($all_books as $book) {
    echo $book->id . ": ".$book->name . "\n";
}

// Or count()ed
echo "Total addressbooks: " . count($all_books) . "\n";

$book = new Addressbook();
$book->name = 'Example Created addressbook';
$book->visibility = 'Private';

$response = $request->create($book);
echo "New addressbook (ID " . $response->id . ") created.\n";
$book_id = $response->id;

$response = $request->delete($response->id);
echo "New addressbook (ID " . $book_id . ") deleted.\n";