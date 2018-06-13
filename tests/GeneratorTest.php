<?php
/**
 * Created by PhpStorm.
 * User: norlov
 * Date: 13.06.18
 * Time: 10:19
 */

use Src\Generator;
use PHPUnit\Framework\TestCase;

class GeneratorTest extends TestCase
{
    public function testCreateMax()
    {
        $generator = new Generator();
        $debugger = new \Src\Debugger(false);
        $generator->create(1000000);
        $this->assertLessThan(180, $debugger->time(true));
    }

    public function testCreateUnique()
    {
        $generator = new Generator();
        $result = $generator->create(100);
        $this->assertNotEmpty($result);

        // проверим уникальность точек

        $whereMap = [];
        foreach ($result as $card) {
            if (!array_key_exists($card['from'], $whereMap)) {
                $whereMap[$card['from']] = 0;
            }
            if (!array_key_exists($card['to'], $whereMap)) {
                $whereMap[$card['to']] = 0;
            }

            $whereMap[$card['from']]++;
            $whereMap[$card['to']]++;
        }

        $uniqueResult = [];
        foreach ($whereMap as $whereName => $item) {
            if ($item == 1) {
                $uniqueResult[$whereName] = $item;
            }
        }

        $this->assertCount(2, $uniqueResult);
    }

    public function testCreateShendor()
    {
        $generator = new Generator();
        $result = $generator->create(100, 'Shendor');
        $this->assertNotEmpty($result);
    }

    public function testCreateLenni()
    {
        $generator = new Generator();
        $result = $generator->create(100, 'Lenni');
        $this->assertNotEmpty($result);
    }

    public function testGetName()
    {
        $generator = new Generator();
        $result = $generator->getWhere();
        $this->assertEquals('a', $result);

        $result = $generator->getWhere();
        $this->assertEquals('b', $result);

        for ($i = 0; $i < 24; $i++) {
            $generator->getWhere();
        }

        $result = $generator->getWhere();
        $this->assertEquals('za', $result);

        for ($i = 0; $i < 1000; $i++) {
            $generator->getWhere();
        }
        $result = $generator->getWhere();
        $this->assertEquals('zzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzn', $result);
    }

    public function testGetWheresMax()
    {
        $generator = new Generator();
        $debugger = new \Src\Debugger(false);
        $num = 10000;
        $generator->getWheres($num);
        $this->assertLessThan(180, $debugger->time(true));
    }
}
