<?php

namespace App\Service;

use App\Exception\InvalidIP4Format;
use PHPUnit\Framework\TestCase;

class IPFizzBuzzTest extends TestCase
{
    private $ipFizzBuzz;

    public function setUp(): void
    {
        $this->ipFizzBuzz = new IPFizzBuzz();
    }

    /**
     * @test
     */
    public function shouldThrowExceptionForIpWithoutFourParts()
    {
        $this->expectException(InvalidIP4Format::class);
        $this->ipFizzBuzz->getFizzBuzzByIP("127.0.0");
    }

    /**
     * @test
     */
    public function shouldThrowExceptionForIpWithNanLastPart()
    {
        $this->expectException(InvalidIP4Format::class);
        $this->ipFizzBuzz->getFizzBuzzByIP("127.0.0.sagan");
    }

    /**
     * @test
     */
    public function shouldReturnFizz()
    {
        $this->assertEquals("Fizz", $this->ipFizzBuzz->getFizzBuzzByIP("127.0.0.3"));
    }

    /**
     * @test
     */
    public function shouldReturnBuzz()
    {
        $this->assertEquals("Buzz", $this->ipFizzBuzz->getFizzBuzzByIP("127.0.0.5"));
    }

    /**
     * @test
     */
    public function shouldReturnLastNumber()
    {
        $this->assertEquals("7", $this->ipFizzBuzz->getFizzBuzzByIP("127.0.0.7"));
    }

    /**
     * @test
     */
    public function shouldReturnFizzBuzz()
    {
        $this->assertEquals("FizzBuzz", $this->ipFizzBuzz->getFizzBuzzByIP("127.0.0.15"));
    }
}