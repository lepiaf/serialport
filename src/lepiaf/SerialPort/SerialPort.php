<?php

namespace lepiaf\SerialPort;

use lepiaf\SerialPort\Configure\ConfigureInterface;
use lepiaf\SerialPort\Configure\TTYConfigure;
use lepiaf\SerialPort\Exception\DeviceNotAvailable;
use lepiaf\SerialPort\Exception\DeviceNotFound;
use lepiaf\SerialPort\Exception\DeviceNotOpened;
use lepiaf\SerialPort\Exception\WriteNotAllowed;
use lepiaf\SerialPort\Parser\ParserInterface;
use lepiaf\SerialPort\Parser\SeparatorParser;

/**
 * SerialPort to handle serial connection easily with PHP
 * Suitable for Arduino communication
 *
 * @author Thierry Thuon <lepiaf@users.noreply.github.com>
 * @copyright MIT
 */
class SerialPort
{
    /**
     * File descriptor
     *
     * @var resource
     */
    private $fd;

    /**
     * @var ParserInterface
     */
    private $parser;

    /**
     * @var ConfigureInterface
     */
    private $configure;

    /**
     * @param ParserInterface|null    $parser
     * @param ConfigureInterface|null $configure
     */
    public function __construct(ParserInterface $parser = null, ConfigureInterface $configure = null)
    {
        $this->parser = $parser;
        $this->configure = $configure;
    }

    /**
     * Open serial connection
     *
     * @param string $device path to device
     * @param string $mode fopen mode
     *
     * @return bool
     *
     * @throws DeviceNotAvailable|DeviceNotFound
     */
    public function open($device, $mode = "w+b")
    {
        if (false === file_exists($device)) {
            throw new DeviceNotFound();
        }

        $this->getConfigure()->configure($device);
        $this->fd = fopen($device, $mode);

        if (false !== $this->fd) {
            stream_set_blocking($this->fd, false);

            return true;
        }

        unset($this->fd);
        throw new DeviceNotAvailable($device);
    }

    /**
     * Write data into serial port line
     *
     * @param string $data
     *
     * @return int length of byte written
     *
     * @throws WriteNotAllowed|DeviceNotOpened
     */
    public function write($data)
    {
        $this->ensureDeviceOpen();

        if (false !== ($dataWritten = fwrite($this->fd, $data))) {
            return $dataWritten;
        }

        throw new WriteNotAllowed();
    }

    /**
     * Read data byte per byte until separator found
     *
     * @return string
     */
    public function read()
    {
        $this->ensureDeviceOpen();

        $chars = [];

        do {
            $char = fread($this->fd, 1);
            $chars[] = $char;
        } while ($char != $this->getParser()->getSeparator());

        return $this->getParser()->parse($chars);
    }

    /**
     * Close serial connection
     *
     * @return bool return true on success
     *
     * @throws DeviceNotOpened
     */
    public function close()
    {
        $this->ensureDeviceOpen();

        return fclose($this->fd);
    }

    /**
     * configure serial line
     *
     * @return ConfigureInterface
     */
    private function getConfigure()
    {
        if (null === $this->configure) {
            $this->configure = new TTYConfigure();
        }

        return $this->configure;
    }

    /**
     * Get parser, if not defined, return new line parser by default
     *
     * @return ParserInterface
     */
    private function getParser()
    {
        if (null === $this->parser) {
            $this->parser = new SeparatorParser();
        }

        return $this->parser;
    }

    /**
     * @throws DeviceNotOpened
     */
    private function ensureDeviceOpen()
    {
        if (!$this->fd) {
            throw new DeviceNotOpened();
        }
    }
}
