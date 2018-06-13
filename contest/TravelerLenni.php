<?php

namespace Contest;

class TravelerLenni
{
    
    /*
     * input data type 
     * array
     * {from(string)|to(string)|transport_type(string)|transport_property(array)}
     * 
     * 
     * 
     * output data type Text
     *  •	Take train 78A from Madrid to Barcelona. Seat 45B.
     *  •	Take the airport bus from Barcelona to Gerona Airport. No seat assignment.
     *  •	From Gerona Airport, take flight SK455 to Stockholm. Gate 45B. Seat 3A. Baggage drop at ticket counter 344.
     *  •	From Stockholm, take flight SK22 to New York JFK. Gate 22. Seat 7B. Baggage will be automatically transferred from your last leg.
     */
    
    
    
    
    public static function makeTravel($data, $sortStyle = 0)
    {
        if (!is_array($data)) {
            return 'Invalid data format';
        }
        
        $response = null;
        if ($sortStyle) {
            switch ($sortStyle) {
                case 2:
                    $preparedData = self::prepareInputData($data);
                    break;
                case 1:
                    $preparedData = self::strangeSort($data);
                    break;
                default:
                    $response = 'Invalid sort style!';
                    break;
            }
        }
        
        if (!$response) {
            $response  = self::prepareOutputText($preparedData);
        }
        return $response;
    }
    
    //recursion metods
    private static function prepareInputData($data)
    {
        $input = array();
        foreach ($data as $array) {
            $input[$array['to']] = $array;
        }
        $input = self::findMain($input);
        
        $output = self::treeview($input);
        $outputArray = self::tree2array($output);

        $outputArray = self::prepareOutputData($outputArray);
        
        return $outputArray;
    }
    
    private static function treeview($results, $parentId = null) 
    {
        $arr = array();
        foreach ($results as $id => $item) {
            if ($parentId == $item['from']) {
                $arr[$id] = $item;
                $arr[$id]['child'] = self::treeview($results, $id);
            }
        }
        return count($arr) ? $arr : null;
    }
    
    private static function findMain($input) 
    {
        $main = '';
        foreach ($input as $array) {
            $from = $array['from'];
            if (!array_key_exists($from, $input)) {
                $main = $from;
            }
        }
        $input[$main]['from'] = null;
        return $input;
    }
    
    private static function prepareOutputData($output) 
    {
        foreach ($output as $key => $array) {
            if (array_key_exists('child', $array)) {
                unset($output[$key]['child']);
            }
        }
        unset($output[0]);
        return $output;
    }
    
    private static function tree2array( $tree, $depth = 0 ) {
        $array = [];
        if (is_array($tree)) {
            foreach( $tree as $node ) {
                array_push ($array,$node);
                if (isset($node['child'])) {
                    $array = array_merge ($array, self::tree2array( $node['child'], $depth+1 ));
                }
            }
        }
        return $array;
    }
    
    private static function prepareOutputText($output) 
    {
//        die(var_dump($output));
        $text = '<ul type="disc">';
        foreach ($output as $array) {
            $text .= "<li>From " . $array['from'] . ', take ' . $array['transport_type'] . ' to ' . $array['to'] . '. ';
            foreach ($array['transport_property'] as $name => $property) {
                $text .= $name . ' ' . $property . '. ';
                $text .= '</li>' . "\n";
            }
            
        }
        $text .= '</ul>';
        return $text;
    }
    
    
    
    
    
    private static function strangeSort($data) 
    {
        $responseArray = array();
        $mainCard = self::getMain($data);
        if ($mainCard) {
            $responseArray[] = $mainCard;
            for ($i=0; $i<count($data)-1; $i++) {
                $card=null;
                $card = self::getNext(end($responseArray)['to'], $data);
                if ($card){
                    $responseArray[] = $card;
                }
            }
        }
        return $responseArray;
    }
    
    private static function getMain($input) 
    {
        $temp = array();
        foreach ($input as $array) {
            $temp[$array['to']] = $array;
        }
        $main = '';
        foreach ($temp as $array) {
            $from = $array['from'];
            if (!array_key_exists($from, $temp)) {
                $main = $array;
            }
        }
        unset($temp);
        return $main;
    }
    
    private static function getNext($target, $data) 
    {
        foreach ($data as $array) {
            if ($array['from'] == $target) {
                return $array;
            }
        }
        return null;
    }
}

