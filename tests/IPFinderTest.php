<?php

namespace App\Service;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class IPFinderTest extends TestCase
{
    private $http;
    private $ipFinder;

    public function setUp(): void
    {
        $this->http = $this->createMock(Client::class);
        $this->ipFinder = new IPFinder($this->http);
    }

    /**
     * @test
     */
    public function shouldReturnIPWithoutLineBreak()
    {
        $this->http->method('request')->willReturn(new class {
            public function getBody()
            {
                return "127.0.0.1\n";
            }
        });
        
        $this->assertEquals("127.0.0.1", $this->ipFinder->findIp());
    }
}