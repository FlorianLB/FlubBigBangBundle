<?php

namespace Flub\BigBangBundle\Tests\Command;

use Flub\BigBangBundle\Command\AliceLoadFixturesCommand;

class AliceLoadFixturesCommandTest extends \PHPUnit_Framework_TestCase
{
    public function testMatchPattern()
    {
        $command = new AliceLoadFixturesCommand();
        $reflMethod = new \ReflectionMethod($command, 'matchPattern');
        $reflMethod->setAccessible(true);

        $this->assertTrue($reflMethod->invoke($command, 'FooBarBundle', 'Foo'));
        $this->assertTrue($reflMethod->invoke($command, 'FooBarBundle', 'Bar'));
        $this->assertTrue($reflMethod->invoke($command, 'FooBarBundle', 'FooBarBundle'));
        $this->assertFalse($reflMethod->invoke($command, 'FooBarBundle', 'PonyBundle'));
    }

    public function testGetAliceFiles()
    {
        $command = new AliceLoadFixturesCommand();
        $reflMethod = new \ReflectionMethod($command, 'getAliceFiles');
        $reflMethod->setAccessible(true);

        $files = $reflMethod->invoke(
            $command,
            __DIR__ . '/../Fixtures/FooBundle',
            'prod'
        );
        $this->assertEquals($files->count(), 2);
    }
}
