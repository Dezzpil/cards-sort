<?php
/**
 * Created by PhpStorm.
 * User: Dezzpil
 * Date: 13.06.2018
 * Time: 20:53
 */

include_once 'vendor/autoload.php';

$gen = new \Src\Generator();
$cards = $gen->create(1000);

xhprof_enable(XHPROF_FLAGS_MEMORY + XHPROF_FLAGS_CPU + XHPROF_FLAGS_NO_BUILTINS);

$traveler = new \Src\Traveler();
$result = $traveler->buildMap($cards);

$xhprofData = xhprof_disable();

include_once "xhprof/xhprof_lib/utils/xhprof_lib.php";
include_once "xhprof/xhprof_lib/utils/xhprof_runs.php";

$source = "xhprof_testing";
$xhprofRuns = new XHProfRuns_Default();
$runId = $xhprofRuns->save_run($xhprofData, $source);

echo "http://localhost:3000/index.php?run={$runId}&source={$source}\n";
