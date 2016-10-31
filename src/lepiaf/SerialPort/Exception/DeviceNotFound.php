<?php

namespace lepiaf\SerialPort\Exception;

class DeviceNotFound extends \Exception
{
    protected $message = "Device path does not exist.";
}
