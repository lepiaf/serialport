<?php

use lepiaf\SerialPort\SerialPort;
use lepiaf\SerialPort\Parser\SeparatorParser;
use lepiaf\SerialPort\Configure\TTYConfigure;

$configure = new TTYConfigure();
//change baud rate
$configure->removeOption("9600");
$configure->setOption("115200");

$serialPort = new SerialPort(new SeparatorParser(), $configure);

$serialPort->open("/dev/ttyACM0");
while ($data = $serialPort->read()) {
    echo $data."\n";

    if ($data === "OK") {
        $serialPort->write("1\n");
        $serialPort->close();
    }
}
