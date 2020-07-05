<?php

namespace App\Service;

use App\Entity\Location;
use App\Exception\ErrorOnFindingLocation;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class LocationFinderTest extends TestCase
{
    private $http;
    private $locationFinder;

    public function setUp(): void
    {
        $this->http = $this->createMock(Client::class);
        $this->locationFinder = new LocationFinder($this->http);
    }

    /**
     * @test
     */
    public function shouldThrowException()
    {
        $this->http->method('request')->willReturn(new class {
            public function getStatusCode()
            {
                return 500;
            }
        });

        $this->expectException(ErrorOnFindingLocation::class);
        $this->locationFinder->findLocation('127.0.0.1');
    }

    /**
     * @test
     */
    public function shouldReturnLocation()
    {
        $this->http->method('request')->willReturn(new class {
            public function getStatusCode()
            {
                return 200;
            }
            
            public function getBody()
            {
                return '{
                    "continent_code": "SA",
                    "country_name": "Brazil",
                    "city": "Rio de Janeiro",
                    "timezone": "America/Sao_Paulo"
                }';
            }
        });
        
        $location = $this->locationFinder->findLocation('127.0.0.1');
        $this->assertEquals('SA', $location->getContinent());
        $this->assertEquals('Brazil', $location->getCountry());
        $this->assertEquals('Rio de Janeiro', $location->getCity());
        $this->assertEquals('America/Sao_Paulo', $location->getTimezone());
    }
}