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

sleep(2);
$debugger = new \Src\Debugger();
$traveler = new \Src\Traveler();
$result = $traveler->buildMap($cards);
echo $debugger->memoryFromPs() . " kb \n";
$debugger->time();
unset($debugger);
