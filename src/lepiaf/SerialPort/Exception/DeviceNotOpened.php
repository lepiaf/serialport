<?php

namespace lepiaf\SerialPort\Exception;

class DeviceNotOpened extends \Exception
{
    protected $message = "Device is not opened. Open it first.";
}
