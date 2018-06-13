<?php
/**
 * Created by PhpStorm.
 * User: norlov
 * Date: 13.06.18
 * Time: 14:31
 */

//[
//    'from' => 'Stockholm',
//    'to' => 'New York JFK',
//    'transport' => [
//        'aircraft' => [
//            'num' => 'SK22',
//            'gate'=> '22',
//            'seat' => '7B',
//            'notes' => 'Baggage will be automatically transferred from your last leg',
//        ]
//    ]
//],

namespace Contest;

class TravelerShendor
{
    /**
     * Замена Ключа массива
     * @param $cards
     * @param $i
     * @param $j
     * @return mixed
     */
    function swapIndex($cards, $i, $j)
    {
        $temp = $cards[$i];
        $cards[$i] = $cards[$j];
        $cards[$j] = $temp;

        return $cards;
    }

    /**
     * Сортировка массива
     * @param $cards
     * @return mixed
     */
    function cardSort($cards)
    {
        $countsCard = count($cards);

        for ($i = 0; $i < $countsCard; $i++) {
            for ($j= $i + 1; $j < $countsCard; $j++) {
                if ($cards[$i]['from'] == $cards[$j]['to']) {
                    $cards = $this->swapIndex($cards, $i, $j);

                    return $this->cardSort($cards);
                }
            }
        }

        return ($cards) ;
    }

    /**
     * Отображение карточек маршрута
     * @param $cards
     */
    function displayCard($cards)
    {
        $tickets = $this->cardSort($cards);

        foreach ($tickets as $ticket) {
            foreach ( $ticket['transport'] as $transport => $data) {

                $from = $ticket['from'];
                $to = $ticket['to'];
                $num = $data['num'];
                $gate = $data['gate'] ? $data['gate'] : '';
                $seat = $data['seat'] ? $data['seat'] : '';
                $notes = $data['notes'] ? $data['notes'] : '';

                switch ($transport) {
                    case 'aircraft':
                        echo "<li>From $from, take flight $num to $to. Gate $gate. Seat $seat. $notes.</li>";
                        break;
                    case 'train':
                        echo "<li>Take $transport $num from $from to $to. Seat $seat.</li>";
                        break;
                    case 'bus':
                        echo "<li>Take the airport  $transport $num from $from to $to. Seat $seat.</li>";
                        break;
                    default:
                        echo "<li>Take $transport $num from $from to $to.</li>";
                }
            }
            echo "\n";
        };
    }
}