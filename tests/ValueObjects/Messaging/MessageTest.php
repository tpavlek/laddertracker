<?php

namespace Depotwarehouse\LadderTracker\Tests\ValueObjects\Messaging;

use Depotwarehouse\Blumba\Domain\DateTimeValue;
use Depotwarehouse\LadderTracker\ValueObjects\Messaging\Message;

class MessageTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function it_can_serialize_to_a_string()
    {
        $message = "This is a test string";
        $value = new Message($message, DateTimeValue::now());

        $this->assertEquals($message, (string)$value);
    }

    /**
     * @test
     */
    public function it_can_build_an_empty_message()
    {
        $message = Message::emptyMessage();

        $this->assertEquals("", (string)$message);
    }

    /**
     * @test
     */
    public function it_can_check_if_it_is_empty()
    {
        $message = new Message("", DateTimeValue::now());

        $this->assertTrue($message->isEmpty());

        $message = new Message("    ", DateTimeValue::now());

        $this->assertTrue($message->isEmpty());

        $message = new Message("Cool message", DateTimeValue::now());

        $this->assertFalse($message->isEmpty());
    }

    /**
     * @test
     */
    public function it_can_get_expiry()
    {
        $now = DateTimeValue::now();

        $message = new Message("Some Message", $now);

        $this->assertEquals($now, $message->expiry());
    }

}
