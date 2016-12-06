<?php
// Get the PHP helper library from twilio.com/docs/php/install
require_once dirname(__FILE__) . '/Twilio/autoload.php'; // Loads the library
use Twilio\Rest\Client;

// Your Account Sid and Auth Token from twilio.com/user/account
$sid = "AC10321732dfae146c0cd97a592da3b6c7";
$token = "ee0db4810ed3754ec58215072f4b8bd4";
$client = new Client($sid, $token);

$client->messages->create(
    "+584161788273",
    array(
        'to' => "+584161788273",
        'from' => '+1 602-388-1023',
        'body' => "Hola vale. Esto es una prueba",
    )
);
