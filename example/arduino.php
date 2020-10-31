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

$addMoreCountOnce = true;

while ($data = $serialPort->read()) {
    var_dump($data);

    if ($data === "END COUNT") {
        if ($addMoreCountOnce === false) {
            break;
        }

        $serialPort->write("10\n");
        $addMoreCountOnce = false;
    }
}

$serialPort->close();
