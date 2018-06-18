<?php
/**
 * Created by PhpStorm.
 * User: norlov
 * Date: 13.06.18
 * Time: 9:47
 */

namespace Src;

class Traveler
{
//    protected $pointsFrom = [];
//    protected $pointsTo = [];
//
//    protected $items = [];
    //protected $index = 0;


    /**
     * @param array $cards
     * @return \Generator
     */
//    protected function iterate(array $cards)
//    {
//        while (array_key_exists($this->index, $cards)) {
//            yield $cards[$this->index++];
//        }
//    }

    /**
     * @param array $cards
     * @return array
     */
    public function buildMap(array $items): array
    {
        $result = [];
        //$this->index = 0;

        $pointsFrom = [];
        $pointsTo = [];
        //$items = [];

//        foreach ($this->iterate($cards) as $card) {
//            $index = $this->index - 1;
//
//            $items[$index] = $card;
//            $pointsTo[$card['to']] = $index;
//            $pointsFrom[$card['from']] = $index;
//        }

        //$items = $cards;
        foreach ($items as $index => $card) {
            //$index = $this->index - 1;

            //$items[$index] = $card;
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

//        if (count($unicPoints) > 1) {
//            throw new \RangeException('Указано несколько начальных пунктов');
//        }
        if ($startFrom === null) {
            throw new \RangeException();
        }

//        $startFrom = $unicPoints[0];
        unset($pointsTo); // no need anymore

//        $factory = new CardFactory();
//
//        // add first manually
//        $transport = $this->getTransport($startFrom, $factory);
//        while (true) {
//            $result[] = $transport->getDescription();
//            $to = $transport->getTo();
//            if (!array_key_exists($to, $this->pointsFrom)) {
//                // конечный пункт (из него больше никуда не едем)
//                break;
//            }
//
//            $transport = $this->getTransport($to, $factory);
//        }

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

//    /**
//     * @param $point
//     * @param CardFactory $factory
//     * @return Transport
//     */
//    protected function getTransport($point, CardFactory $factory): Transport
//    {
//        $index = $this->pointsFrom[$point];
//        $card = $this->items[$index];
//        $transport = $factory->forgeFromArray($card);
//
//        unset($this->pointsFrom[$point]);
//        unset($this->items[$index]);
//
//        return $transport;
//    }

//    /**
//     * @param array $cards
//     * @return array
//     */
//    public function __invoke(array $cards)
//    {
//        $result = $this->buildMap($cards);
//        return $result;
//    }

}