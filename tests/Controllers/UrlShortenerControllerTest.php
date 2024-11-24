<?php

namespace Tests\Controllers;

use Tests\TestCase;

class UrlShortenerControllerTest extends TestCase
{

    public function test_index()
    {
        $response = $this->get('/api/v1/urlshortener');
        $response->seeJson();

        $content = json_decode($response->response->getContent(), true);

        $this->assertFalse($content['error']);
        $this->assertEquals(200, $content['code']);
        $this->assertNotEmpty($content['data']);
        //response
    }

    public function test_create()
    {
        $response = $this->post('/api/v1/urlshortener');
        $response->seeJson();

        $content = json_decode($response->response->getContent(), true);

        $this->assertTrue($content['error']);
        $this->assertEquals(422, $content['code']);
        $this->assertEmpty($content['data']);
        $this->assertNotEmpty($content['errors']);

        $response2 = $this->post('/api/v1/urlshortener', ['original' => 'https://wwww.google.com']);
        $response2->seeJson();

        $content2 = json_decode($response->response->getContent(), true);

        $this->assertFalse($content2['error']);
        $this->assertEquals(201, $content2['code']);
        $this->assertNotEmpty($content2['data']);
        $this->assertArrayHasKey('url', $content2['data']);
        $this->assertArrayHasKey('shortened', $content2['data']);
    }

    public function test_delete()
    {
        $response = $this->delete('/api/v1/urlshortener/2');
        $response->seeJson();

        $content = json_decode($response->response->getContent(), true);

        $this->assertFalse($content['error']);
        $this->assertEquals(200, $content['code']);
        $this->assertNotEmpty($content['data']);
        $this->assertArrayHasKey('wasDeleted', $content['data']);
        $this->assertEquals(1, $content['data']['wasDeleted']);
    }
}
