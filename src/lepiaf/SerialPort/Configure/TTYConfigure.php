<?php

namespace lepiaf\SerialPort\Configure;

/**
 * Configuration for linux
 */
class TTYConfigure implements ConfigureInterface
{
    /**
     * Default configuration, suitable for Arduino serial connection
     *
     * @var array
     */
    private $options = [
        'cs8' => true,
        '9600' => true,
        'ignbrk' => true,
        'brkint' => false,
        'icrnl' => false,
        'imaxbel' => false,
        'opost' => false,
        'onlcr' => false,
        'isig' => false,
        'icanon' => false,
        'iexten' => false,
        'echo' => false,
        'echoe' => false,
        'echok' => false,
        'echoctl' => false,
        'echoke' => false,
        'noflsh' => true,
        'ixon' => false,
        'crtscts' => false,
    ];

    /**
     * {@inheritdoc}
     */
    public function configure($device)
    {
        exec(sprintf('stty -F %s %s', $device, $this->getOptions()));
    }

    /**
     * @param string $value
     * @param bool   $active
     */
    public function setOption($value, $active = true)
    {
        $this->options[$value] = (bool) $active;
    }

    /**
     * @param string $value
     */
    public function removeOption($value)
    {
        unset($this->options[$value]);
    }

    /**
     * If not options has been defined, get default.
     *
     * @return string
     */
    protected function getOptions()
    {
        $options = [];
        foreach ($this->options as $value => $active)  {
            $options[] = $this->getActiveString($active).$value;
        }

        return implode(" ", $options);
    }

    /**
     * @param string $active
     *
     * @return string
     */
    private function getActiveString($active)
    {
        return $active === false ? "-" : "";
    }
}
