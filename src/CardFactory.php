<?php
/**
 * Created by PhpStorm.
 * User: norlov
 * Date: 13.06.18
 * Time: 9:54
 */

namespace Src;

class CardFactory
{
    public function forgeFromArray(array $card): Transport
    {
        // find type
        // create corresponded object, if able to
        // else, create base Transport object
        $transport = new Transport();
        $transport->setData($card['type'], $card['info']);
        $transport->setPoints($card['from'], $card['to']);

        return $transport;
    }
}