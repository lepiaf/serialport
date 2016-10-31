<?php

namespace lepiaf\SerialPort\Parser;

interface ParserInterface
{
    /**
     * Parse data right after read from serial connection
     *
     * @param array $chars array of chars
     *
     * @return mixed
     */
    public function parse(array $chars);

    /**
     * Separator use to split data
     *
     * @return string
     */
    public function getSeparator();
}
