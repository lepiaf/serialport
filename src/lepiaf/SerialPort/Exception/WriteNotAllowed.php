<?php

namespace lepiaf\SerialPort\Exception;

class WriteNotAllowed extends RuntimeException
{
    protected $message = "Write not allowed on device. Please check fopen mode.";
}
