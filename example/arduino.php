<?php

use lepiaf\SerialPort\SerialPort;
use lepiaf\SerialPort\Parser\SeparatorParser;
use lepiaf\SerialPort\Configure\TTYConfigure;

$serialPort = new SerialPort(new SeparatorParser(), new TTYConfigure());

$serialPort->open("/dev/ttyACM0");
while ($data = $serialPort->read()) {
    echo $data."\n";

    if ($data === "OK") {
        $serialPort->write("1\n");
        $serialPort->close();
    }
}
