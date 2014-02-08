<?php

namespace Flub\BigBangBundle\Tests\Command;

use Flub\BigBangBundle\Command\InitCommand;
use Symfony\Component\Console\Tester\CommandTester;

class InitCommandTest extends \PHPUnit_Framework_TestCase
{
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
}
