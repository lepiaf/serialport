# SerialPort

Class to handle serial port with php.

Inspired by [PHP-Serial](https://github.com/Xowap/PHP-Serial), I simplify it and include composer.json to install via composer.

## How to use

```php
<?php

use lepiaf\SerialPort\SerialPort;
use lepiaf\SerialPort\Parser\SeparatorParser;
use lepiaf\SerialPort\TTYConfigure;

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
