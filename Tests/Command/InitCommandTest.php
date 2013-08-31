<?php

namespace Flub\BigBangBundle\Tests\Command;

use Flub\BigBangBundle\Command\InitCommand;
use Symfony\Component\Console\Tester\CommandTester;

class InitCommandTest extends \PHPUnit_Framework_TestCase
{
    public function testBehat()
    {
        $command = $this->getMock('Flub\BigBangBundle\Command\InitCommand', array('execBehat'));

        $command
            ->expects($this->once())
            ->method('execBehat');

        $tester = new CommandTester($command);
        $tester->execute(array('--behat' => true));
    }

    public function testAnt()
    {
        $command = $this->getMock('Flub\BigBangBundle\Command\InitCommand', array('execAnt'));

        $command
            ->expects($this->exactly(3))
            ->method('execAnt');

        $tester = new CommandTester($command);
        $tester->execute(array('--ant' => true));
        $tester->execute(array('--jenkins' => true));
        $tester->execute(array('--ant' => true, '--jenkins' => true));
    }

    public function testMultiArgs()
    {
        $command = $this->getMock('Flub\BigBangBundle\Command\InitCommand', array(
            'execAnt',
            'execBehat'
        ));

        $command
            ->expects($this->once())
            ->method('execBehat');

        $command
            ->expects($this->once())
            ->method('execAnt');

        $tester = new CommandTester($command);
        $tester->execute(array('--behat' => true, '--jenkins' => true));
    }
}
