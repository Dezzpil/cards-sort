<?php
/**
 * Created by PhpStorm.
 * User: norlov
 * Date: 13.06.18
 * Time: 14:05
 */

namespace Src;


class Debugger
{
    protected $time;
    protected $memory;
    protected $verbose;

    public function __construct($verbose = true)
    {
        $this->verbose = $verbose;
        $this->time = microtime(true);
        $this->memory = memory_get_usage(true);
        if ($verbose) {
            echo "\nDebug enabled:\n";
        }
    }

    public function time($raw = false)
    {
        $now = microtime(true);
        $elapsed = round($now - $this->time, 3) * 1000;
        $this->time = $now;
        if ($raw) {
            return $elapsed;
        } else {
            echo $elapsed . " ms\n";
        }
    }

    public function memory()
    {
        $now = memory_get_usage(true);
        $usage = round(($now - $this->memory) / 1024, 3);
        $this->memory = $now;
        echo $usage . " kb\n";
    }

    public function __destruct()
    {
        if ($this->verbose) {
            echo "Debug complete\n";
        }
    }
}