<?php
namespace CsrfShield\Tests\Integration;

use CsrfShield\Protection;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class ProtectionTest extends TestCase
{
    const BASE_URI = 'http://localhost:8000/';

    const TIME_DELAY = 2;

    /**
     * A Guzzle wrapper that deals with the HTTP communication.
     *
     * @var array
     */
    private $http;

    /**
     * The response from the HTTP endpoint.
     *
     * @var array
     */
    private $response;

    public function setUp()
    {
        sleep(self::TIME_DELAY);

        $this->http = new Client([
            'base_uri' => self::BASE_URI,
            'cookies' => true,
            'exceptions' => false
        ]);
    }

    public function tearDown() {
        $this->http = null;
    }

    /**
     * @test
     */
    public function hello_world_GET_200()
    {
        $this->response = $this->http->request('GET', 'hello-world.php');

        $dom = new \DOMDocument;
        $dom->loadHTML($this->response->getBody()->getContents());

        $xp = new \DOMXpath($dom);
        $nodes = $xp->query('//input[@name="_csrf_shield_token"]');
        $node = $nodes->item(0);
        $token = $node->getAttribute('value');

        $this->assertEquals(200, $this->response->getStatusCode());
        $this->assertTrue(is_string($token));
        $this->assertEquals(40, strlen($token));
    }

    /**
     * @test
     */
    public function hello_world_POST_200()
    {
        $this->response = $this->http->request('GET', 'hello-world.php');

        $dom = new \DOMDocument;
        $dom->loadHTML($this->response->getBody()->getContents());

        $xp = new \DOMXpath($dom);
        $nodes = $xp->query('//input[@name="_csrf_shield_token"]');
        $node = $nodes->item(0);
        $token = $node->getAttribute('value');

        $this->assertEquals(200, $this->response->getStatusCode());
        $this->assertTrue(is_string($token));
        $this->assertEquals(40, strlen($token));

        $this->response = $this->http->request(
            'POST',
            'hello-world.php', [
                'form_params' =>  [
                    '_csrf_shield_token' => $token
                ]
            ]
        );

        $this->assertEquals(200, $this->response->getStatusCode());
    }

    /**
     * @test
     */
    public function hello_world_POST_403()
    {
        $this->response = $this->http->request('GET', 'hello-world.php');

        $dom = new \DOMDocument;
        $dom->loadHTML($this->response->getBody()->getContents());

        $xp = new \DOMXpath($dom);
        $nodes = $xp->query('//input[@name="_csrf_shield_token"]');
        $node = $nodes->item(0);
        $token = $node->getAttribute('value');

        $this->assertEquals(200, $this->response->getStatusCode());
        $this->assertTrue(is_string($token));
        $this->assertEquals(40, strlen($token));

        $this->response = $this->http->request(
            'POST',
            'hello-world.php', [
                'form_params' =>  [
                    '_csrf_shield_token' => 'foo'
                ]
            ]
        );

        $this->assertEquals(403, $this->response->getStatusCode());
    }
}
