<?php
declare(strict_types=1);

namespace Igdb\Tests\Unit\Resources;

use Igdb\ApiClient;
use Igdb\Tests\Base;
use Lukasoppermann\Httpstatus\Httpstatuscodes as Status;

class AgeRatingContentDescriptionTest extends Base
{
    private const RESOURCE = 'AgeRatingContentDescription';

    /** @test */
    public function fetch()
    {
        $client = new ApiClient($this->config, $this->getMockHttpClient(self::RESOURCE, __FUNCTION__));

        $response = $client->ageRatingsContentDescriptions()->fetch();
        $data = $response->getData();

        $this->assertEquals(Status::HTTP_OK, $response->getResponse()->getStatusCode());
        $this->assertIsArray($data);
    }

    /** @test */
    public function fields()
    {
        $client = new ApiClient($this->config, $this->getMockHttpClient(self::RESOURCE, __FUNCTION__));

        $data = $client->ageRatingsContentDescriptions()->fetch('fields checksum, description;')->getData();

        foreach ($data as $datum) {
            $this->assertArrayHasKey('checksum', $datum);
            $this->assertArrayHasKey('description', $datum);
        }
    }

    /** @test */
    public function where()
    {
        $client = new ApiClient($this->config, $this->getMockHttpClient(self::RESOURCE, __FUNCTION__));

        $data = $client->ageRatingsContentDescriptions()->fetch('where id = (100, 200);')->getData();

        $this->assertEquals([['id' => 100], ['id' => 200]], $data);
    }

    /** @test */
    public function limit()
    {
        $client = new ApiClient($this->config, $this->getMockHttpClient(self::RESOURCE, __FUNCTION__));

        $this->assertCount(2, $client->ageRatingsContentDescriptions()->fetch('limit 2;')->getData());
    }
}
