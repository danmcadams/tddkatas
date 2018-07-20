<?php declare(strict_types=1);


namespace Tests\Greeting;

use Kata\Greeting\Greeter;
use PHPUnit\Framework\TestCase;

class GreetingTest extends TestCase
{
    /** @var Greeter */
    protected $greeter;

    public function setUp()
    {
        $this->greeter = new Greeter();
    }

    public function testGreetSingleName()
    {
        $name = 'johnny';
        $this->assertEquals(sprintf('Hello, %s.', $name), $this->greeter->greet($name));
    }

    public function testNoNameProvided()
    {
        $this->assertEquals('Hello, my friend.', $this->greeter->greet());
    }

    public function testShoutGreeting()
    {
        $name = 'DAN';
        $this->assertEquals(sprintf('HELLO %s!', $name), $this->greeter->greet($name));
    }

    public function testTwoNames()
    {
        $names    = ['Billy', 'Zane'];
        $expected = 'Hello, Billy and Zane.';

        $this->assertEquals($expected, $this->greeter->greet($names));
    }

    public function testMultipleNames()
    {
        $names    = ['Billy', 'Bobby', 'Sue', 'Jane'];
        $expected = 'Hello, Billy, Bobby, Sue, and Jane.';

        $this->assertEquals($expected, $this->greeter->greet($names));
    }

    public function testStandardAndShouting()
    {
        $names    = ['Billy', 'BOB', 'Dino'];
        $expected = 'Hello, Billy and Dino. AND HELLO BOB!';

        $this->assertEquals($expected, $this->greeter->greet($names));
    }

    public function testSplitCommaStrings()
    {
        $names    = ['Billy', 'Bob, Dino'];
        $expected = 'Hello, Billy, Bob, and Dino.';

        $this->assertEquals($expected, $this->greeter->greet($names));
    }

    public function testEscapedCommasWithQuotations()
    {
        $names    = ['Billy', '"Bob, Dino"'];
        $expected = 'Hello, Billy and Bob, Dino.';

        $this->assertEquals($expected, $this->greeter->greet($names));
    }
}
