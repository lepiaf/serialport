<?php

namespace lepiaf\SerialPort\Configure;

/**
 * Configuration for linux
 */
class TTYConfigure implements ConfigureInterface
{
    /**
     * List of argument that will passed to stty command
     *
     * @var array
     */
    private $options = [];

    /**
     * Default configuration, suitable for Arduino serial connection
     *
     * @var array
     */
    private $default = [
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
     * @param $value
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
        if (!$this->options) {
            $this->options = $this->default;
        }

        $options = [];
        foreach ($this->options as $value => $active)  {
            $options[] = $this->getActiveString($active).$value;
        }

        return join(" ", $options);
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
