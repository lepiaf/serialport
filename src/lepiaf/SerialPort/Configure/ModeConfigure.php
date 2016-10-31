<?php

namespace lepiaf\SerialPort;

use lepiaf\SerialPort\Configure\ConfigureInterface;

/**
 * Configuration for windows
 */
class ModeConfigure implements ConfigureInterface
{
    /**
     * {@inheritdoc}
     */
    public function configure($device)
    {
        throw new \Exception("Not implemented yet");
    }
}
