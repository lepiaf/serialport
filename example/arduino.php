<?php

require_once '../vendor/autoload.php';

use lepiaf\SerialPort\SerialPort;
use lepiaf\SerialPort\Parser\SeparatorParser;
use lepiaf\SerialPort\Configure\TTYConfigure;

//change baud rate
$configure = new TTYConfigure();
$configure->removeOption("9600");
$configure->setOption("115200");

$serialPort = new SerialPort(new SeparatorParser("\n"), $configure);


$serialPort->open("/dev/ttyACM0");
while ($data = $serialPort->read()) {
    var_dump($data);

    if ($data === "END COUNT") {
        break;
    }
}

$serialPort->close();
