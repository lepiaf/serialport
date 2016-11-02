<?php

namespace lepiaf\SerialPort\Exception;

class DeviceNotFound extends RuntimeException
{
    protected $message = "Device path does not exist.";
}
