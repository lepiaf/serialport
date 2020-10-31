<?php

namespace Tests\Configure;

use lepiaf\SerialPort\Configure\TTYConfigure;
use phpmock\phpunit\PHPMock;
use PHPUnit\Framework\TestCase;

class TTYConfigureTest extends TestCase
{
    use PHPMock;

    public function testConfigure()
    {
        $configure = new TTYConfigure();

        $exec = $this->getFunctionMock('lepiaf\\SerialPort\\Configure', "exec");
        $exec->expects($this->once())->willReturnCallback(
            function ($command) {
                $this->assertEquals("stty -F ".__DIR__."/../dummyDevice cs8 9600 ignbrk -brkint -icrnl -imaxbel -opost -onlcr -isig -icanon -iexten -echo -echoe -echok -echoctl -echoke noflsh -ixon -crtscts", $command);
            }
        );

        $configure->configure(__DIR__ . '/../dummyDevice');
    }

    public function testConfigureWithCustomOption()
    {
        $configure = new TTYConfigure();
        $configure->removeOption('9600');
        $configure->setOption('115200');
        $configure->setOption('ignbrk', false);
        $configure->setOption('opost', true);
        $configure->setOption('onlcr', false);

        $exec = $this->getFunctionMock('lepiaf\\SerialPort\\Configure', 'exec');
        $exec->expects($this->once())->willReturnCallback(
            function ($command) {
                $this->assertEquals('stty -F '.__DIR__.'/../dummyDevice cs8 -ignbrk -brkint -icrnl -imaxbel opost -onlcr -isig -icanon -iexten -echo -echoe -echok -echoctl -echoke noflsh -ixon -crtscts 115200', $command);
            }
        );

        $configure->configure(__DIR__ . '/../dummyDevice');
    }
}
