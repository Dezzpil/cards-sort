<?php
/**
 * Created by PhpStorm.
 * User: norlov
 * Date: 13.06.18
 * Time: 14:47
 */

include_once 'vendor/autoload.php';

echo "---------------------------------------\n";
$generator = new \Src\Generator();
$cards = $generator->create(10000);

$debugger = new \Src\Debugger();
$traveler = new \Contest\TravelerDezzpil();
$result = $traveler($cards);
$debugger->time();
$debugger->memory();
unset($debugger);

echo "---------------------------------------\n";
$generator = new \Src\Generator();
$cards = $generator->create(10000, 'Lenni');

$debugger = new \Src\Debugger();
\Contest\TravelerLenni::makeTravel($cards,1);
$debugger->time();
$debugger->memory();
unset($debugger);

$debugger = new \Src\Debugger();
\Contest\TravelerLenni::makeTravel($cards,2);
$debugger->time();
$debugger->memory();
unset($debugger);

echo "---------------------------------------\n";
error_reporting(~E_NOTICE);

$generator = new \Src\Generator();
$cards = $generator->create(10000, 'Shendor');

$debugger = new \Src\Debugger();
$traveler = new \Contest\TravelerShendor();
$traveler->cardSort($cards);
$debugger->time();
$debugger->memory();
unset($debugger);

