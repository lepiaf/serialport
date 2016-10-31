<?php

namespace lepiaf\SerialPort\Parser;

class SeparatorParser implements ParserInterface
{
    /**
     * @var string
     */
    private $separator;

    /**
     * @param string $separator
     */
    public function __construct($separator = "\n")
    {
        $this->separator = $separator;
    }

    /**
     * {@inheritdoc}
     */
    public function getSeparator()
    {
        return $this->separator;
    }

    /**
     * {@inheritdoc}
     */
    public function parse(array $chars)
    {
        return join('', $chars);
    }
}
