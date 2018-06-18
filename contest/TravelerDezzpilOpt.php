<?php
/**
 * Created by PhpStorm.
 * User: norlov
 * Date: 13.06.18
 * Time: 9:47
 */

namespace Contest;

class TravelerDezzpilOpt
{
    public function buildMap(array $items): array
    {
        $result = [];

        $pointsFrom = [];
        $pointsTo = [];

        foreach ($items as $index => $card) {
            $pointsTo[$card['to']] = $index;
            $pointsFrom[$card['from']] = $index;
        }

        $startFrom = null;
        foreach ($pointsFrom as $from => $index) {
            if (!array_key_exists($from, $pointsTo)) {
                $startFrom = $from;
                break;
            }
        }

        if ($startFrom === null) {
            throw new \RangeException();
        }

        unset($pointsTo); // no need anymore

        $point = $startFrom;
        while (true) {
            $index = $pointsFrom[$point];
            $card = $items[$index];

            $result[] = "Take {$card['type']} from {$card['from']} to {$card['to']}. ";
            unset($pointsFrom[$point]);
            unset($items[$index]);

            // берем следующий пункт назначения
            $point = $card['to'];
            if (!array_key_exists($point, $pointsFrom)) {
                // конечный пункт (из него больше никуда не едем)
                unset($pointsFrom);
                break;
            }
        }

        return $result;
    }
}