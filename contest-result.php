<?php
/**
 * Created by PhpStorm.
 * User: norlov
 * Date: 13.06.18
 * Time: 15:04
 */

include_once 'vendor/autoload.php';

function dump($array)
{
    foreach ($array as $item) {
        print $item . "\n";
    }
    print "--------------------------\n";
}


$generator = new \Src\Generator();
$cards = $generator->create(5);

$traveler = new \Contest\TravelerDezzpil();
$result = $traveler($cards);
dump($result);


$generator = new \Src\Generator();
$cards = $generator->create(5, 'Lenni');

$result = \Contest\TravelerLenni::makeTravel($cards,1);
var_dump($result);

$result = \Contest\TravelerLenni::makeTravel($cards,2);
var_dump($result);


error_reporting(~E_NOTICE);
$generator = new \Src\Generator();
$cards = $generator->create(5, 'Shendor');

$traveler = new \Contest\TravelerShendor();
$traveler->displayCard($cards);
echo "==============================\n";