<?php

namespace lepiaf\SerialPort\Configure;

/**
 * Configuration for mac
 */
class TTYMacConfigure extends TTYConfigure
{
    /**
     * {@inheritdoc}
     */
    public function configure($device)
    {
        exec(sprintf('stty -f %s %s', $device, $this->getOptions()));
    }
}
