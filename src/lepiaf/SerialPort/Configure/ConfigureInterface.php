<?php

namespace lepiaf\SerialPort\Configure;

interface ConfigureInterface
{
    /**
     * Configure serial line
     *
     * @param $device
     *
     * @return mixed
     */
    public function configure($device);
}