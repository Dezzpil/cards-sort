<?php
/**
 * Created by PhpStorm.
 * User: norlov
 * Date: 13.06.18
 * Time: 9:53
 */

namespace Src;

class Generator
{
    const STYLE_DEZZPIL = 'Dezzpil';
    const STYLE_LENNI = 'Lenni';
    const STYLE_SHENDOR = 'Shendor';

    static protected $what = [
        ["type" => "flight", "info" => "SK22;Gate 22;Seat 7B;Baggage will be automatically transferred from your last leg"],
        ["type" => "flight", "info" => "SK455;Gate 45B;Seat 3A;Baggage drop at ticket counter 344"],
        ["type" => "bus", "info" => "No seat assignment"],
        ["type" => "car", "info" => "Number 0888 050;Mechanical"],
        ["type" => "bike", "info" => null]
    ];
    static protected $alphabet = 'a b c d e f g h j i k l m n o p q r s t u v w x y z a';

    protected $counter = 0;
    protected $alpabetMap = [];
    protected $alpabetResult = [];

    public function __construct()
    {
        $this->alpabetMap = explode(' ', self::$alphabet);
    }

    /**
     * @return string
     */
    public function getWhere(): string
    {
        $length = intdiv($this->counter, 26);
        $index = $this->counter % 26;

        for ($i = 1; $i <= $length + 1; $i++) {
            $this->alpabetResult[$length] = $index;
        }

        $this->counter++;
        $result = '';
        foreach ($this->alpabetResult as $i => $val) {
            $result .= $this->alpabetMap[$val];
        }
        return $result;
    }

    /**
     * @param $num 10k - max
     * @param bool $shuffle
     * @return array
     */
    public function getWheres($num, $shuffle = true): array
    {
        if ($num > 10003) $num = 10003;

        $result = [];
        for ($i = 0; $i < $num; $i++) {
            $result[] = $this->getWhere();
        }

        if ($shuffle) {
            shuffle($result);
        }
        return $result;
    }


    protected function formCardDataForDezzpil(array $card, array $raw)
    {
        $card['type'] = $raw['type'];
        $card['info'] = $raw['info'];
        return $card;
    }

    protected function formCardDataForShendor(array $card, array $raw)
    {
        $type = $raw['type'];
        $card['transport'][$type] = [];

        $keys = ['num', 'gate', 'seat', 'notes'];
        $values = explode(';', $raw['info']);
        foreach ($values as $index => $value) {
            $card['transport'][$type][$keys[$index]] = $value;
        }
        return $card;
    }

    protected function formCardDataForLenni(array $card, array $raw)
    {
        $card['transport_type'] = $raw['type'];
        $card['transport_property'] = explode(';', $raw['info']);
        return $card;
    }

    /**
     * @param int $num 10k - max
     * @return array
     */
    public function create($num = 10, $style = self::STYLE_DEZZPIL): array
    {
        if ($num > 10000) $num = 10000; // Time: 175 ms, Memory: 10.00MB

        $cards = [];
        $what = array_merge([], self::$what);
        $typesMaxIndex = count($what) - 1;

        $wheres = $this->getWheres($num + 3);
        $start = array_pop($wheres);
        $end = array_pop($wheres);

        $previous = $wheres[0];
        for ($i = 0; $i < $num; $i++) {

            $current = $wheres[$i + 1];
            $rnd = rand(0, $typesMaxIndex);

            $card = [ 'from' => $previous, 'to' => $current ];
            $formMethod = 'formCardDataFor' . $style;
            $card = $this->$formMethod($card, $what[$rnd]);

            $cards[] = $card;

            $previous = $current;
        }

        $cards[0]['from'] = $start;
        $cards[$i-1]['to'] = $end;

        return $cards;
    }
}