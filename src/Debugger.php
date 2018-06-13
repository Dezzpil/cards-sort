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
    protected $ps;

    public function __construct($verbose = true)
    {
        $this->verbose = $verbose;
        $this->time = microtime(true);
        $this->memory = memory_get_usage(true);
        if ($verbose) {
            echo "\nDebug enabled:\n";
        }

        $pid = getmypid();
        exec("ps --pid $pid --no-headers -o rss", $output);
        $this->ps = $output[0];
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

    /**
     * @return string in kb
     */
    public function memoryFromPs()
    {
        $pid = getmypid();
        exec("ps --pid $pid --no-headers -o rss", $output);
        return $output[0] - $this->ps;

    }

    public function __destruct()
    {
        if ($this->verbose) {
            echo "Debug complete\n";
        }
    }
}