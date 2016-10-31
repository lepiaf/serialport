<?php

namespace lepiaf\SerialPort;

use lepiaf\SerialPort\Exception\DeviceNotAvailable;

/**
 * @author Thierry Thuon <lepiaf@users.noreply.github.com>
 * @copyright MIT
 */
class SerialPort 
{
    private $fd;

    public function open($device) 
    {
        // configure tty port
        exec('stty -F '.$device.' cs8 9600 ignbrk -brkint -icrnl -imaxbel -opost -onlcr -isig -icanon -iexten -echo -echoe -echok -echoctl -echoke noflsh -ixon -crtscts');
        $this->fd = fopen($device, 'w+b');

        if (false !== $this->fd) {
            stream_set_blocking($this->fd, false);

            return true;
        }

        throw new DeviceNotAvailable($device);
    }

    public function write($data) 
    {
        return fwrite($this->fd, $data);
    }

    public function read($seperator) 
    {
        $chars = [];
        $char = 0;

        do {
            $char = fread($this->fd, 1);
            $chars[] = $char;
        } while ($char != $seperator);

        return substr(join('', $chars), 0, -1);
    }

    public function close()
    {
        return fclose($this->fd);
    }   
}
