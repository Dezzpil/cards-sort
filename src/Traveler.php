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
    protected $pointsFrom = [];
    protected $pointsTo = [];

    protected $items = [];
    protected $index = 0;


    /**
     * @param array $cards
     * @return \Generator
     */
    protected function iterate(array $cards)
    {
        while (array_key_exists($this->index, $cards)) {
            yield $cards[$this->index++];
        }
    }

    /**
     * @param array $cards
     * @return array
     */
    public function buildMap(array $cards): array
    {
        $result = [];
        $this->index = 0;

        foreach ($this->iterate($cards) as $card) {
            $index = $this->index - 1;

            $this->items[$index] = $card;
            $this->pointsTo[$card['to']] = $index;
            $this->pointsFrom[$card['from']] = $index;


        }

        $unicPoints = [];
        foreach ($this->pointsFrom as $from => $index) {
            if (!array_key_exists($from, $this->pointsTo)) {
                $unicPoints[] = $from;
            }
        }

        if (count($unicPoints) > 1) {
            throw new \RangeException('Указано несколько начальных пунктов');
        }

        $startFrom = $unicPoints[0];
        unset($this->pointsTo); // no need anymore

        $factory = new CardFactory();

        // add first manually
        $transport = $this->getTransport($startFrom, $factory);
        $result[] = vsprintf(
            "Take %s from %s to %s. %s", $transport->getValuesForTemplate()
        );

        while (true) {
            $to = $transport->getTo();
            if (!array_key_exists($to, $this->pointsFrom)) {
                // конечный пункт (из него больше никуда не едем)
                break;
            }

            $transport = $this->getTransport($to, $factory);
            $result[] = vsprintf(
                "Take %s from %s to %s. %s", $transport->getValuesForTemplate()
            );
        }

        return $result;
    }

    /**
     * @param $point
     * @param CardFactory $factory
     * @return Transport
     */
    protected function getTransport($point, CardFactory $factory): Transport
    {
        $index = $this->pointsFrom[$point];
        $card = $this->items[$index];
        $transport = $factory->forgeFromArray($card);

        unset($this->pointsFrom[$point]);
        unset($this->items[$index]);

        return $transport;
    }

    /**
     * @param array $cards
     * @return array
     */
    public function __invoke(array $cards)
    {
        $result = $this->buildMap($cards);
        return $result;
    }

}