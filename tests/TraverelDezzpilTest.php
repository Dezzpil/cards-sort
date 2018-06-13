<?php
/**
 * Created by PhpStorm.
 * User: norlov
 * Date: 13.06.18
 * Time: 12:33
 */

use Src\Generator;
use Src\Guidebook;
use PHPUnit\Framework\TestCase;

class TraverelDezzpilTest extends TestCase
{

    public function testBuildMap()
    {
        $generator = new Generator();
        $cards = $generator->create(100);

        $sorter = new \Contest\TravelerDezzpil();
        $result = $sorter->buildMap($cards);

        $this->assertNotEmpty($result);
    }

    public function testChain()
    {
        $generator = new Generator();
        $cards = $generator->create(50000);

        $sorter = new \Contest\TravelerDezzpil();
        $sorted = $sorter->buildMap($cards);

        $this->assertNotEmpty($sorted);
        $this->assertEquals(count($cards), count($sorted));

        //var_dump($sorted);
    }


}
