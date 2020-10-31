<?php

namespace Tests;

use lepiaf\SerialPort\Configure\ConfigureInterface;
use lepiaf\SerialPort\Parser\SeparatorParser;
use lepiaf\SerialPort\SerialPort;
use PHPUnit\Framework\TestCase;

class SerialPortTest extends TestCase
{
    const DUMMY_DEVICE = __DIR__.'/dummyDevice';

    public function testOpen()
    {
        $configure = $this->createMock(ConfigureInterface::class);
        $configure->expects($this->once())->method('configure')->with(self::DUMMY_DEVICE);

        $serialPort = new SerialPort(new SeparatorParser(";"), $configure);

        self::assertTrue($serialPort->open(self::DUMMY_DEVICE, 'r+b'));
        self::assertSame("hello;", $serialPort->read());
        self::assertSame("world;", $serialPort->read());
    }

    public function testClose()
    {
        $configure = $this->createMock(ConfigureInterface::class);
        $configure->expects($this->once())->method('configure')->with(self::DUMMY_DEVICE);

        $serialPort = new SerialPort(new SeparatorParser(";"), $configure);

        self::assertTrue($serialPort->open(self::DUMMY_DEVICE, 'r+b'));
        self::assertTrue($serialPort->close());
    }
}
