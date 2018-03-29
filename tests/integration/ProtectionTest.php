<?php
namespace CsrfShield\Tests\Integration;

use CsrfShield\Protection;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class ProtectionTest extends TestCase
{
    const BASE_URI = 'http://localhost:8000/';

    const TIME_DELAY = 1;

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
    public function auto_processing_form_GET_200()
    {
        $this->response = $this->http->request('GET', 'auto-processing-form.php');

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
    public function auto_processing_form_POST_200()
    {
        $this->response = $this->http->request('GET', 'auto-processing-form.php');

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
            'auto-processing-form.php', [
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
    public function auto_processing_form_POST_403()
    {
        // HTTP/1.1 GET
        $this->response = $this->http->request('GET', 'auto-processing-form.php');
        // do nothing with the response

        // HTTP/1.1 POST
        // send a foo token
        $this->response = $this->http->request(
            'POST',
            'auto-processing-form.php', [
                'form_params' =>  [
                    '_csrf_shield_token' => 'foo'
                ]
            ]
        );

        $this->assertEquals(403, $this->response->getStatusCode());
        $this->assertEquals(
            '{"message":"Forbidden."}',
            $this->response->getBody()->getContents()
        );
    }

    /**
     * @test
     */
    public function ajax_get_token_200()
    {
        $this->response = $this->http->request('GET', 'ajax/get-token.php');

        $json = json_decode(
            $this->response->getBody()->getContents(),
            true
        );

        $this->assertEquals(200, $this->response->getStatusCode());
        $this->assertTrue(is_string($json['_csrf_shield_token']));
        $this->assertEquals(40, strlen($json['_csrf_shield_token']));
    }

    /**
     * @test
     */
    public function ajax_post_token_200()
    {
        $this->response = $this->http->request('GET', 'ajax/get-token.php');

        $json = json_decode(
            $this->response->getBody()->getContents(),
            true
        );

        $this->assertEquals(200, $this->response->getStatusCode());
        $this->assertTrue(is_string($json['_csrf_shield_token']));
        $this->assertEquals(40, strlen($json['_csrf_shield_token']));

        $this->response = $this->http->request(
            'POST',
            'ajax/post-token.php', [
                'headers' => [
                    'X-CSRF-Token' => $json['_csrf_shield_token']
                ]
            ]
        );

        $this->assertEquals(200, $this->response->getStatusCode());
    }

    /**
     * @test
     */
    public function ajax_post_token_403()
    {
        // HTTP/1.1 GET
        $this->response = $this->http->request('GET', 'ajax/get-token.php');
        // do nothing with the response

        // HTTP/1.1 POST
        // send a foo token
        $this->response = $this->http->request(
            'POST',
            'ajax/post-token.php', [
                'headers' => [
                    'X-CSRF-Token' => 'foo'
                ]
            ]
        );

        $this->assertEquals(403, $this->response->getStatusCode());
        $this->assertEquals(
            '{"message":"Forbidden."}',
            $this->response->getBody()->getContents()
        );
    }

    /**
     * @test
     */
    public function ajax_post_token_405()
    {
        // HTTP/1.1 GET
        $this->response = $this->http->request('GET', 'ajax/get-token.php');
        // do nothing with the response

        // HTTP/1.1 GET
        // send a foo token
        $this->response = $this->http->request(
            'GET',
            'ajax/post-token.php', [
                'headers' => [
                    'X-CSRF-Token' => 'foo'
                ]
            ]
        );

        $this->assertEquals(405, $this->response->getStatusCode());
        $this->assertEquals(
            '{"message":"Method not allowed."}',
            $this->response->getBody()->getContents()
        );
    }
}
