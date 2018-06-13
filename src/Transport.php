<?php
/**
 * Created by PhpStorm.
 * User: norlov
 * Date: 13.06.18
 * Time: 9:35
 */

namespace Src;

class Transport //implements ArrayAccess
{
    protected $from;
    protected $to;
    protected $type;
    protected $data;

    public function setPoints($from, $to)
    {
        $this->from = $from;
        $this->to = $to;
        return $this;
    }

    public function getFrom()
    {
        return $this->from;
    }

    public function getTo()
    {
        return $this->to;
    }

    public function setData($type, $data)
    {
        $this->type = $type;
        $this->data = $data;
        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getData()
    {
        return $this->data;
    }

    /**
     * Override for current childs
     * @return array
     */
    public function getValuesForTemplate()
    {
        return [$this->getType(), $this->getFrom(), $this->getTo(), str_replace(';', '. ', $this->data)];
    }
}