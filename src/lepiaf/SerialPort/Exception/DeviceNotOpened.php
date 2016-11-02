<?php

namespace lepiaf\SerialPort\Exception;

class DeviceNotOpened extends LogicException
{
    protected $message = "Device is not opened. Open it first.";
}
