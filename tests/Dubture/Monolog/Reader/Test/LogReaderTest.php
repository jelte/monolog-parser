<?php

/*
 * This file is part of the monolog-parser package.
 *
 * (c) Robert Gruendler <r.gruendler@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dubture\Monolog\Reader\Test;

use Dubture\Monolog\Reader\LogReader;


/**
 * @author Robert Gruendler <r.gruendler@gmail.com>
 */
class LogReaderTest extends \PHPUnit_Framework_TestCase
{
    public function testReader()
    {
        $file = __DIR__ . '/../../../../files/test.log';
        $logParser = $this->getMock('Dubture\Monolog\Parser\LogParserInterface', array(), array(), '', false);
        $logParser->expects($this->exactly(2))->method('parse')->will($this->returnValue(array()));
        $reader = new LogReader($file, $logParser);

        $log = $reader[0];
        $this->assertInternalType('array', $log);

        $log = $reader[1];
        $this->assertInternalType('array', $log);
    }

    public function testIterator()
    {
        $file = __DIR__ . '/../../../../files/test.log';
        $logParser = $this->getMock('Dubture\Monolog\Parser\LogParserInterface', array(), array(), '', false);
        $logParser->expects($this->exactly(2))->method('parse')->will($this->returnValue(array()));
        $reader = new LogReader($file, $logParser);
        $lines = array();
        $keys = array();

        $this->assertEquals(2, count($reader));

        foreach ($reader as $i => $log) {
            $lines[] = $log;
            $keys[] = $i;
        }

        $this->assertEquals(array(0, 1), $keys);
        $this->assertCount(2, $lines);

    }

    /**
     * @expectedException RuntimeException
     */
    public function testException()
    {
        $file = __DIR__ . '/../../../../files/test.log';
        $logParser = $this->getMock('Dubture\Monolog\Parser\LogParserInterface', array(), array(), '', false);
        $reader = new LogReader($file, $logParser);
        $reader[5] = 'foo';

    }
}
