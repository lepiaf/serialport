# SerialPort

Connect to serial port with PHP

Inspired by [PHP-Serial](https://github.com/Xowap/PHP-Serial), I simplify it and include composer.json to install via composer.

Actually, it works on linux. This library is suitable for working with Arduino. 

## Install via composer

```
composer require "lepiaf/serialport"
```

## How to use

Instantiate a new SerialPort object with a parser and configure tty.

```php
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
```

For mac os, you must use `TTYMacConfigure`. It will use `stty -f` instead of `stty -F`.

```php
<?php

use lepiaf\SerialPort\SerialPort;
use lepiaf\SerialPort\Parser\SeparatorParser;
use lepiaf\SerialPort\Configure\TTYMacConfigure;

$serialPort = new SerialPort(new SeparatorParser(), new TTYMacConfigure());

$serialPort->open("/dev/ttyACM0");
while ($data = $serialPort->read()) {
    echo $data."\n";

    if ($data === "OK") {
        $serialPort->write("1\n");
        $serialPort->close();
    }
}
```
