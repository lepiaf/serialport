<?php

namespace Tests\Parser;

use lepiaf\SerialPort\Parser\SeparatorParser;
use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{
    public function testParse()
    {
        $parser = new SeparatorParser();
        self::assertSame("\n", $parser->getSeparator());
        self::assertSame("hello\nworld", $parser->parse(['h', 'e', 'l', 'l', 'o', "\n", 'w', 'o', 'r', 'l', 'd']));
    }

    public function testParseCustomSeperator()
    {
        $parser = new SeparatorParser(',');
        self::assertSame(',', $parser->getSeparator());
        self::assertSame('hello,world', $parser->parse(['h', 'e', 'l', 'l', 'o', ',', 'w', 'o', 'r', 'l', 'd']));
    }
}
