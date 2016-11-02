<?php

namespace lepiaf\SerialPort\Exception;

class DeviceNotAvailable extends RuntimeException
{
    protected $message = "Cannot open device. Please check permission on device path.";
}
